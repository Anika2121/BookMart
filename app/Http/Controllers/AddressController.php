<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private const MAX_ADDRESSES = 5;

    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('buyer.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->addresses()->count() >= self::MAX_ADDRESSES) {
            return back()->with('error', 'Maximum ' . self::MAX_ADDRESSES . ' addresses can be saved.');
        }

        $validated = $request->validate([
            'label'          => ['required', 'in:Home,Office,Other'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone'          => ['required', 'string', 'max:20'],
            'address_line'   => ['required', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'district'       => ['required', 'string', 'max:100'],
            'postal_code'    => ['nullable', 'string', 'max:10'],
            'is_default'     => ['boolean'],
        ]);

        // If new default, remove previous one
        if (!empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        }

        // First address is always default
        if ($user->addresses()->count() === 0) {
            $validated['is_default'] = true;
        }

        $user->addresses()->create($validated);

        return back()->with('success', 'New address added successfully.');
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'label'          => ['required', 'in:Home,Office,Other'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone'          => ['required', 'string', 'max:20'],
            'address_line'   => ['required', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'district'       => ['required', 'string', 'max:100'],
            'postal_code'    => ['nullable', 'string', 'max:10'],
        ]);

        $address->update($validated);

        return back()->with('success', 'Address updated successfully.');
    }

    public function setDefault(Address $address)
    {
        $this->authorize('update', $address);

        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address has been changed.');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        if ($address->is_default && auth()->user()->addresses()->count() > 1) {
            // Make the next one default
            auth()->user()->addresses()
                ->where('id', '!=', $address->id)
                ->first()
                ->update(['is_default' => true]);
        }

        $address->delete();

        return back()->with('success', 'Address has been deleted.');
    }
}
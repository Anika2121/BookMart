<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();

        if (!$coupon || !$coupon->isValid($total)) {
            return redirect()->back()->with('coupon_error', 'Invalid or expired coupon code!');
        }

        $discount = $coupon->calculateDiscount($total);

        session()->put('coupon', [
            'code'     => $coupon->code,
            'discount' => $discount,
            'type'     => $coupon->type,
            'value'    => $coupon->value,
        ]);

        return redirect()->back()->with('coupon_success', 'Coupon applied! You saved ৳' . $discount);
    }

    public function remove()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed!');
    }
}
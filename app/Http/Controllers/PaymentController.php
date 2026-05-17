<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    private function getSslConfig(): array
    {
        return [
            'store_id'       => config('services.sslcommerz.store_id'),
            'store_password' => config('services.sslcommerz.store_password'),
            'sandbox'        => config('services.sslcommerz.sandbox', true),
        ];
    }

    public function initiatePayment(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment && $order->payment->status === 'completed') {
            return redirect()->route('orders.my')
                ->with('info', 'This order is already paid.');
        }

        $txnId = 'BM-' . strtoupper(uniqid()) . '-' . $order->id;

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'sslcommerz',
                'amount' => $order->price,
                'txn_id' => $txnId,
                'status' => 'pending',
            ]
        );

        $ssl    = $this->getSslConfig();
        $apiUrl = $ssl['sandbox']
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';

        $order->load(['book', 'buyer']);

        $postData = [
            'store_id'            => $ssl['store_id'],
            'store_passwd'        => $ssl['store_password'],
            'total_amount'        => $order->price,
            'currency'            => 'BDT',
            'tran_id'             => $txnId,
            'success_url'         => route('payment.success'),
            'fail_url'            => route('payment.fail'),
            'cancel_url'          => route('payment.cancel'),
            'ipn_url'             => route('payment.ipn'),
            'product_name'        => $order->book->title ?? 'Book',
            'product_category'    => 'Books',
            'product_profile'     => 'general',
            'cus_name'            => auth()->user()->name,
            'cus_email'           => auth()->user()->email,
            'cus_phone'           => auth()->user()->phone ?? '01700000000',
            'cus_add1'            => 'Dhaka',
            'cus_city'            => 'Dhaka',
            'cus_country'         => 'Bangladesh',
            'ship_name'           => auth()->user()->name,
            'ship_add1'           => 'Dhaka',
            'ship_city'           => 'Dhaka',
            'ship_country'        => 'Bangladesh',
            'shipping_method'     => 'NO',
            'num_of_item'         => 1,
            'emi_option'          => 0,
        ];

        $response = Http::asForm()->post($apiUrl, $postData);
        $result   = $response->json();

        if (isset($result['GatewayPageURL']) && $result['status'] === 'SUCCESS') {
            return redirect()->away($result['GatewayPageURL']);
        }

        return redirect()->route('orders.my')
            ->with('error', 'Payment gateway error. Please try again.');
    }

    public function success(Request $request)
    {
        $ssl    = $this->getSslConfig();
        $valUrl = $ssl['sandbox']
            ? 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php'
            : 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';

        $response = Http::get($valUrl, [
            'val_id'       => $request->val_id,
            'store_id'     => $ssl['store_id'],
            'store_passwd' => $ssl['store_password'],
            'format'       => 'json',
        ]);

        $result = $response->json();

        if (in_array($result['status'] ?? '', ['VALID', 'VALIDATED'])) {
            $payment = Payment::where('txn_id', $result['tran_id'])->first();
            if ($payment) {
                $payment->update(['status' => 'completed']);
                $payment->order->update(['status' => 'confirmed']);
            }
            return redirect()->route('orders.my')
                ->with('success', 'Payment successful! Order confirmed. ✅');
        }

        return redirect()->route('orders.my')
            ->with('error', 'Payment validation failed.');
    }

    public function fail(Request $request)
    {
        $payment = Payment::where('txn_id', $request->tran_id)->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }
        return redirect()->route('orders.my')
            ->with('error', 'Payment failed. Please try again.');
    }

    public function cancel(Request $request)
    {
        $payment = Payment::where('txn_id', $request->tran_id)->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }
        return redirect()->route('orders.my')
            ->with('error', 'Payment cancelled.');
    }

    public function ipn(Request $request)
    {
        $payment = Payment::where('txn_id', $request->tran_id)->first();
        if ($payment && $request->status === 'VALID') {
            $payment->update(['status' => 'completed']);
            $payment->order->update(['status' => 'confirmed']);
        }
        return response()->json(['status' => 'ok']);
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }
        $order->load(['book.user', 'payment']);
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download('BookMart-Invoice-' . $order->id . '.pdf');
    }
}
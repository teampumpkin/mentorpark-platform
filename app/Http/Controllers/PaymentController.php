<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function createOrder(Request $request)
    {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $order = $api->order->create([
                'receipt' => 'rcptid_' . uniqid(),
                'amount' => $request->amount * 100, // Amount in paise
                'currency' => 'INR',
            ]);

            return response()->json([
                'order_id' => $order['id'],
                'key' => env('RAZORPAY_KEY'),
                'amount' => $request->amount,
                'currency' => 'INR',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function verifyPayment(Request $request)
    {
        $signatureStatus = false;

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);
            $signatureStatus = true;
        } catch (Exception $e) {
            $signatureStatus = false;
        }

        if ($signatureStatus) {
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            $paymentMethod = $payment->method;
            // Find the order in your database using razorpay_order_id
            $orders = Order::where('purchase_orderId', $request->purchase_order_id)->get();

            foreach ($orders as $order) {
                if (!$order && $request->filled('order_id')) {
                    $order = Order::where('orderId', $request->order_id)->first();
                }

                if ($order) {
                    $order->payment_status      = 'completed'; // or 'success'
                    $order->payment_method      = $paymentMethod;
                    $order->transaction_id      = $request->razorpay_payment_id;
                    $order->razorpay_order_id   = $request->razorpay_order_id;
                    $order->razorpay_payment_id = $request->razorpay_payment_id;
                    $order->razorpay_signature  = $request->razorpay_signature;
                    $order->isActive            = true;
                    $order->save();
                }
            }
            // If not found, try your local order_id if mapped

            return response()->json(['success' => true, 'message' => 'Payment verified successfully!', 'url' => route('thank-you-payment', ['purchase_order_id' => $request->purchase_order_id])]);
        } else {
            return response()->json(['success' => false, 'message' => 'Payment verification failed!']);
        }
    }

    public function thankYouPayment($purchase_order_id)
    {
        $orders = Order::where('purchase_orderId', $purchase_order_id)->get();
        return view('frontend.thank-you-payment', compact('orders', 'purchase_order_id'));

    }
}

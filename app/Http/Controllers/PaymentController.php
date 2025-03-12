<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function showPayment()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        // validate user input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // store user data in session for success page
        session([
            'payment_details' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'amount' => $validated['amount'],
            ]
        ]);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // convert amount to cents
            $amountInCents = (int) round($validated['amount'] * 100);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => 'Custom Payment',
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $validated['email'],
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
                'metadata' => [
                    'customer_name' => $validated['name'],
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        $paymentDetails = session('payment_details');

        if (!$paymentDetails) {
            return redirect()->route('payment.cancel')->with('error', 'Invalid payment session');
        }

        // clear payment details from session
        session()->forget('payment_details');

        return view('payment-success', [
            'name' => $paymentDetails['name'],
            'email' => $paymentDetails['email'],
            'amount' => $paymentDetails['amount'],
        ]);
    }

    public function cancel()
    {
        session()->forget('payment_details');
        return view('payment-cancel');
    }
}
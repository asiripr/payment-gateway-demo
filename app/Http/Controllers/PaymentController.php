<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Token;

class PaymentController extends Controller
{
    public function showPayment()
    {
        return view('payment');
    }
    public function processPayment(Request $request)
    {
        try {
            //set stripe api key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // create a stripe checkout session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => 'Payment for your vegitables',
                        ],
                        'unit_amount' => 100000 // amount has given in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ]);
            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return "Payment successful!";
    }

    public function cancel()
    {
        return "Payment cancelled.";
    }
}

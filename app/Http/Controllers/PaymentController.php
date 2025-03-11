<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;

class PaymentController extends Controller
{
    public function showPayment(){
        return view('payment');
    }
    public function processPayment(Request $request){
        $request->validate([
            'card_number' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'cvc' => 'required',
        ]);
        try {
            //set stripe api key
            Stripe::setApiKey(env('SSTRIPE_SECRET'));

            // let's create a token using card details
            $token = Token::create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ]
            ]);

            // create a charge
            $charge = Charge::create([
                'amount' => 1000, // amount in cents
                'currency' => 'usd',
                'source' => $token->id,
                'description' => 'demonstration'
            ]);

            return back()->with('success', 'payment successfull!');
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

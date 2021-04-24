<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function makePayment(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge = Charge::create([
                "amount" => 120 * 100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "Make payment and chill."
            ]);

            Session::flash('success', 'Payment successfully processed.');
            return back()->with('charge', $charge);
        } catch (Exception $e) {
            Session::flash('error', 'Error processing payment.');
        }        
    }
}

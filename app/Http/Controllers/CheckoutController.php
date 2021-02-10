<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_PRIVATE_KEY'));

        return view('checkout.payment');
    }

    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_PRIVATE_KEY'));

        $cart = \Cart::session(Auth::user()->id);

        $tax = $cart->getTotal() /10;
        $roundedTax = round($tax, 2);

        try {
            $charge = \Stripe\Charge::create([
                'amount' => ($cart->getTotal() + $roundedTax) * 100,
                'currency' => 'EUR',
                'description' => 'Paiement via Elearning',
                'source' => $request->input('stripeToken'),
                'receipt_email' => Auth::user()->email
            ]);

            return redirect()->route('checkout.success')->with('success', 'Paiement accepté !');
        }
        catch(\Stripe\Exception\CardException $error) {
            throw $error;
        }
    }


    public function success()
    {
        if(! session()->has('success')) {
            return redirect()->route('main.home');
        }

        return view('checkout.success');
    }
}

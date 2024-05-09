<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; 
use Session;

class CheckoutController extends Controller
{

    public function index()
    {
        return view('checkout');
    }

    public function checkout(Request $request){

        \Stripe\Stripe::setApiKey(Config::get('services.stripe.secret'));

        $cart = Session::get('cart', []);
        $lineItems = [];

        foreach ($cart as $cartItems) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'EUR',
                    'unit_amount' => $cartItems['price'] * 100,
                    'product_data' => [
                        'name' => $cartItems['name']
                    ]
                ],
                'quantity' => $cartItems['quantity'],
            ];
        }




        $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => route('checkout.success'),
        'cancel_url' => route('checkout.cancel'),
        ]);

        return Redirect::to($checkout_session->url);
    }

    public function success(Request $request)
    {
        Session::forget('cart');
        return view('success');
    }

    // Handle cancellation
    public function cancel(Request $request)
    {
        return view('cancel');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; 
//use Session;

class PaymentController extends Controller
{

    public function index()
    {
        return view('checkout');
    }

    public function checkout(Request $request){
        \Stripe\Stripe::setApiKey(Config::get('services.stripe.secret'));

        $cart = Session::get('cart', []);
    
        // Calculate total amount
        $total = 0;
        $coupon = session('coupon');
        //dd($coupon->discount);
        
        foreach ($cart as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }
        if ($coupon)
        {
            $total -= $coupon->discount;// Calculate discount based on coupon rules;
        }
        
        // Create line items for Stripe checkout
        $lineItems = [];
        foreach ($cart as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'EUR',
                    'unit_amount' => $cartItem['price'] * 100,
                    'product_data' => [
                        'name' => $cartItem['name']
                    ]
                ],
                'quantity' => $cartItem['quantity'],
            ];
        }

        // Create Stripe checkout session with adjusted total
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);
    
        return redirect()->to($checkout_session->url);
    }

    public function success(Request $request)
    {
        Session::forget('coupon');
        Session::forget('cart');

        return view('success');
    }

    public function cancel(Request $request)
    {
        return view('cancel');
    }

}
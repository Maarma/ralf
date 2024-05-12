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
        // Retrieve cart items from session
        $cart = Session::get('cart', []);
    
        // Calculate total amount
        $total = 0;
        foreach ($cart as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }
    
        // Apply discount if available
        $discountAmount = 0;
        $coupon = Session::get('coupon');
        if ($coupon) {
            // Apply discount based on coupon rules
            // For example, you might have a fixed discount amount or a percentage discount
            // Adjust the total amount accordingly
            
            $discountAmount = $coupon['discount'];
            
        }
    
        // Calculate the final amount after applying the discount
        $finalTotal = $total - $discountAmount;
    
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
            /*'payment_intent_data' => [
                'amount' => $finalTotal * 100, // Amount in cents
                'currency' => 'eur',
                'description' => 'Payment for products',
            ],*/
        ]);
    
        return redirect()->to($checkout_session->url);
    }
    public function success(Request $request)
    {
        Session::forget('coupon');
        Session::forget('cart');
        return view('success');
    }

    // Handle cancellation
    public function cancel(Request $request)
    {
        return view('cancel');
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Records;
use App\Models\Coupon;
use App\Models\Cart;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Integer;
use Stripe\Discount;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responseData = Records::select('product_id', 'name', 'author', 'tracks', 'price', 'image')->get();
        return response()->json($responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $records = Records::create($request->all());

        return response()->json($records, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Records $records)
    {
        return response()->json($records);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Records $records)
    {
        $records->update($request->all());

    return response()->json($records);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Records $records)
    {
        $records->delete();

    return response()->json(null, 204);
    }

public function records(){

    $responseData = Http::get('https://hajusrakendus.ta22maarma.itmajakas.ee/api/records')->json();
    return view('records.records', ['products' => $responseData]);
}
public function makeup(){

    $responseData = Http::get('https://ralf.ta22sink.itmajakas.ee/api/makeup')->json();
    return view('makeup.makeup', ['products' => $responseData]);
}
public function movies(){

    $responseData = Http::get('https://hajus.ta19heinsoo.itmajakas.ee/api/movies');
    $movies = $responseData->json()['data'];
    return view('movies.movies', compact('movies'));
}

public function cart(){
    return redirect()->back()->with('success', 'Item added to cart successfully.');
}

public function addToCart(Request $request)
{
    $product_id = $request->input('product_id');
    $quantity = $request->input('amount');

    // Retrieve product details from the database
    $product = Records::where('product_id', $product_id)->firstOrFail();

    // Get current cart items from session
    $cartItems = session()->get('cart', []);

    // Check if the item already exists in the cart
    $itemIndex = -1;
    foreach ($cartItems as $index => $item) {
        if ($item['product_id'] == $product_id) {
            $itemIndex = $index;
            break;
        }
    }

    // If the item exists in the cart, update its quantity
    if ($itemIndex !== -1) {
        $cartItems[$itemIndex]['quantity'] += $quantity;
    } else {
        // Otherwise, add the new item to the cart
        $cartItems[] = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'quantity' => $quantity,
            'price' => $product['price']
        ];
    }

    // Store the updated cart items back into the session
    session()->put('cart', $cartItems);
    return redirect()->back()->with('success', 'Item added to cart successfully.');
    
}

public function showCart()
{
    session()->forget('coupon');
    $cartItems = session('cart', []);

    $total = 0;
    // Apply coupon discount if present
    $coupon = session('coupon');
    //dd($coupon->discount);
    if ($coupon) {
        $total -= $coupon->discount;// Calculate discount based on coupon rules;
    }

    // Process payment

    foreach ($cartItems as $item) {
        // Cast price and quantity to float to ensure numeric values
        $price = (float)$item['price'];
        $quantity = (int)$item['quantity'];

        // Add the product's price multiplied by its quantity to the total
        $total += $price * $quantity;
    }
    //dd(session('cart'));
    return view('cart', compact('cartItems', 'total'));
}
public function removeFromCart($index)
    {
        // Remove item from cart using the index or any other identifier
        
        // For example, if you are using session to store cart items
        $cart = session()->get('cart');
        
        // Remove the item at the specified index
        unset($cart[$index]);
        
        // Update the session cart with the modified cart
        session()->put('cart', $cart);
        
        // Redirect back or wherever you want after removing from cart
        return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }

public function updateCartItem(Request $request, $index)
{
    $quantity = $request->input('quantity');

    // Get current cart items from session
    $cartItems = session()->get('cart', []);

    // Check if the item being updated is a coupon
    if ($cartItems[$index]['name'] === 'coupon' && $quantity > 1) {
        // If the item is a coupon, limit the quantity to 1
        $quantity = 1;
    }

    // Update the quantity of the item at the specified index
    if (isset($cartItems[$index])) {
        $cartItems[$index]['quantity'] = $quantity;
        session()->put('cart', $cartItems);
    }

    // Redirect back to the cart page
    return redirect()->route('cart')->with('success', 'Cart item updated successfully.');
}

public function applyCoupon(Request $request)
{

    $couponCode = $request->input('coupon_code');
    $coupon = Coupon::where('code', $couponCode)->first();
    $cartItems = session()->get('cart', []);

    if ($coupon) {
        // Apply the discount based on coupon rules
        // Adjust the total amount
        session()->put('coupon', $coupon);
    }
    $cartItems[] = [
        'product_id' => 'coupon',
        'name' => 'coupon',
        'quantity' => 1,
        'price' => $coupon['discount'] * -1
    ];
    session()->put('cart', $cartItems);

    return redirect()->back()->with('success', 'Coupon applied successfully.');
}



}
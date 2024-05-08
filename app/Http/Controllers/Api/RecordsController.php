<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Records;
use App\Models\Cart;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Integer;

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

public function addToCart($product_id)
{
    $product = Records::where('product_id', $product_id)->firstOrFail();
    //dd($product);
    
        // Get current cart items from session
        $cartItems = session()->get('cart', []);
        // Store cart item in the database
        $cartItems[] = ([
            'product_id' => $product_id,
            'name' => $product['name'],
            'quantity' => 1,
            'price' => $product['price']
        ]);
        
    // Store the updated cart items back into the session
    session()->put('cart', $cartItems);
    return redirect()->back()->with('success', 'Item added to cart successfully.');
    
}

public function showCart()
{
    $cartItems = session('cart', []);

    $total = 0;

    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return view('cart', compact('cartItems', 'total'));
}
}
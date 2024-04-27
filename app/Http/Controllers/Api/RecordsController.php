<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Records;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responseData = Records::select('name', 'author', 'tracks', 'price', 'image')->get();
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
/*
    public function records()
{
    $responseData = Records::select('name', 'author', 'tracks', 'price', 'image')->get();
    return view('products.records', ['products' => $responseData]);
}
*/
public function records(){

    $responseData = Http::get('https://hajusrakendus.ta22maarma.itmajakas.ee/api/records')->json();
    return view('records.records', ['products' => $responseData]);
}
public function makeup(){

    $responseData = Http::get('https://ralf.ta22sink.itmajakas.ee/api/makeup')->json();
    return view('makeup.makeup', ['products' => $responseData]);
}
public function movies(){

    $responseData = Http::get('https://hajus.ta19heinsoo.itmajakas.ee/api/movies')->json();
    return view('movies.movies', ['products' => $responseData]);
}
}
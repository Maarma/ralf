<?php

namespace App\Http\Controllers;

use App\Models\Boxmap;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RadarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('radar.index');
    }

    public function addMarker(Request $request)
    {
        $marker = new Boxmap;
        $marker->latitude = $request->input('latitude');
        $marker->longitude = $request->input('longitude');
        $marker->name = $request->input('name');
        $marker->description = $request->input('description');
        $marker->save();
    
        return response()->json(['success' => true]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     */

}

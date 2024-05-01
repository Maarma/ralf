<?php

namespace App\Http\Controllers;

use App\Models\Boxmap;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Ramsey\Uuid\Type\Integer;

class RadarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $markers = Boxmap::all();
        return view('radar.index', compact('markers'));
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
 
        $request->user()->markers()->create($validated);
 
        return redirect(route('markers.index'));
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
    public function edit(Boxmap $marker): View
    {
        $this->authorize('update', $marker);
 
        return view('markers.edit', [
            'marker' => $marker,
        ]);
    }

    public function destroy(Boxmap $marker): RedirectResponse
    {
        $this->authorize('delete', $marker);
 
        $marker->delete();
 
        return redirect(route('markers.index'));
    }

    public function update(Request $request, Boxmap $marker): RedirectResponse
    {
        $this->authorize('update', $marker);
 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
 
        $marker->update($validated);
 
        return redirect(route('markers.index'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Boxmap;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\Config; 

class RadarController extends Controller
{
    
    public function index(): View
    {
        $apiKey = Config::get('services.radar.key');
        $markers = Boxmap::all();

        return view('radar.index', compact('markers', 'apiKey'));
    }

    public function create(Request $request)
    {
        Boxmap::create($request->all());

        return redirect()->route('radar.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
        [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
 
        $request->user()->markers()->create($validated);
 
        return redirect(route('radar.index'));
    }

    public function show()
    {
        //
    }

    public function edit(Boxmap $marker): View
    {
        $this->authorize('update', $marker);
 
        return view('markers.edit', 
        [
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
 
        $validated = $request->validate(
        [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
 
        $marker->update($validated);
 
        return redirect(route('markers.index'));
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Boxmap;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Ramsey\Uuid\Type\Integer;

class MarkerController extends Controller
{

    public function index(): View
    {
        $markers = Boxmap::all();

        return view('markers.index', compact('markers'));
    }

    public function create()
    {
        return view('markers.add');
    }

    public function store(Request $request)
    {
        Boxmap::create($request->all());
        
        return redirect()->route('markers.index');
    }

    public function show()
    {
        //
    }

    public function edit(Boxmap $marker): View
    {
        return view('markers.edit', compact('marker'));
    }

    public function destroy(Boxmap $marker): RedirectResponse
    {
        $marker->delete();

        return redirect()->route('markers.index');
    }

    public function update(Request $request, Boxmap $marker): RedirectResponse
    {
        $marker->update($request->all());

        return redirect()->route('markers.index');
    }

}

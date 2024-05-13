<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ChirpController extends Controller
{

    public function index(): View
    {
        //dd(Chirp::with('user')->latest()->get(),Comment::with('chirp')->get());
        
        return view('chirps.index', 
        [
            'chirps' => Chirp::with('user')->latest()->get(),
            'comments' => Comment::with('chirp')->latest()->get()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
        [
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->chirps()->create($validated);
 
        return redirect(route('chirps.index'));
    }

    public function show(Chirp $chirp)
    {
        //
    }

    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);
 
        return view('chirps.edit',
        [
            'chirp' => $chirp,
        ]);
    }

    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);
 
        $validated = $request->validate(
        [
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
    public function storeComment(Request $request, Chirp $chirp): RedirectResponse
    {
        $validated = $request->validate(
        [
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->comment = $validated['comment'];
        $comment->user_id = $request->user()->id;
        $comment->chirp_id = $chirp->id;
        $comment->save();

        return back()->with('success', 'Comment posted successfully.');
    }

}
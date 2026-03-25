<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WishController extends Controller
{
    use AuthorizesRequests;
    public function index() {
        $wishes = (auth()->user()->role === 'user') 
            ? auth()->user()->wishes 
            : Wish::with('user')->get();

        return view('dashboard', compact('wishes'));
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required|string|max:255']);
        auth()->user()->wishes()->create($request->all());
        return back();
    }

    public function destroy(Wish $wish) {
        $this->authorize('delete', $wish);
        $wish->delete();
        return back();
    }
}

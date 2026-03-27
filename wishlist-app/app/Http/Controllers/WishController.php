<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;

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

    // Взять желание на исполнение
    public function reserve(Wish $wish)
    {
        $wish->update([
            'status' => 'reserved',
            'reserved_by' => auth()->id(),
        ]);
        return back()->with('success', 'Вы взяли желание на исполнение!');
    }

    // Исполнить желание
    public function fulfill(Wish $wish)
    {
        $wish->update(['status' => 'fulfilled']);
        return back()->with('success', 'Желание исполнено!');
    }
    
    public function show(User $user)
    {
        $wishes = $user->wishes()->latest()->get();
        return view('wishes.show', compact('user', 'wishes'));
    }
}

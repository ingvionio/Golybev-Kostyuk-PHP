<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    // Отправить заявку в друзья
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $friend = User::where('email', $request->email)->first();

        if ($friend->id === auth()->id()) {
            return back()->with('error', 'Нельзя добавить себя в друзья');
        }

        $exists = Friendship::where('user_id', auth()->id())
            ->where('friend_id', $friend->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Заявка уже отправлена');
        }

        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $friend->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Заявка отправлена!');
    }

    // Принять заявку
    public function accept(Friendship $friendship)
    {
        $friendship->update(['status' => 'accepted']);
        return back()->with('success', 'Друг добавлен!');
    }

    // Список входящих заявок
    public function requests()
    {
        $requests = Friendship::where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('friends.requests', compact('requests'));
    }

    // Список друзей
    public function index()
    {
        $friends = Friendship::where(function($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('friend_id', auth()->id());
            })
            ->where('status', 'accepted')
            ->with('user', 'friend')
            ->get();

        return view('friends.index', compact('friends'));
    }
}
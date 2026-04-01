<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
    
class WishController extends Controller
{
    use AuthorizesRequests;

    public function index() 
    {
        $user = auth()->user();

        $wishes = $user->wishes()->latest()->get();

        // Получаем отчеты текущего пользователя
        $reports = \App\Models\ErrorReport::where('user_id', $user->id)->latest()->get();

        return view('dashboard', compact('wishes', 'reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'is_private' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['is_private'] = $request->has('is_private');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('wishes', 'public');
            $data['image'] = $path;
        }

        auth()->user()->wishes()->create($data);
        return back()->with('success', 'Желание добавлено!');
    }

    public function destroy(Wish $wish) {
        $this->authorize('delete', $wish);
        
        if ($wish->image) {
            Storage::disk('public')->delete($wish->image);
        }

        $wish->delete();
        return back();
    }

    public function edit(Wish $wish)
    {
        $this->authorize('update', $wish);
        return view('wishes.edit', compact('wish'));
    }

    public function update(Request $request, Wish $wish)
    {
        $this->authorize('update', $wish);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'is_private' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['is_private'] = $request->has('is_private');

        if ($request->hasFile('image')) {
            if ($wish->image) {
                Storage::disk('public')->delete($wish->image);
            }
            $data['image'] = $request->file('image')->store('wishes', 'public');
        }

        $wish->update($data);
        return redirect()->route('dashboard')->with('success', 'Желание обновлено!');
    }

    public function reserve(Wish $wish)
    {
        $wish->update([
            'status' => 'reserved',
            'reserved_by' => auth()->id(),
        ]);
        return back()->with('success', 'Вы взяли желание на исполнение!');
    }

    public function fulfill(Wish $wish)
    {
        $wish->update(['status' => 'fulfilled']);
        return back()->with('success', 'Желание исполнено!');
    }
    
    public function show(User $user)
    {
        // Проверяем, являются ли пользователи друзьями
        $isFriend = \App\Models\Friendship::where('status', 'accepted')
            ->where(function ($query) use ($user) {
                $query->where('user_id', auth()->id())->where('friend_id', $user->id)
                      ->orWhere('user_id', $user->id)->where('friend_id', auth()->id());
            })->exists();

        $query = $user->wishes()->latest();

        // Если это не наш профиль, мы не друзья и мы не админ -> скрываем приватные желания
        if (!$isFriend && auth()->id() !== $user->id && auth()->user()->role !== \App\Enums\Role::ADMIN) {
            $query->where('is_private', false);
        }

        $wishes = $query->get();

        return view('wishes.show', compact('user', 'wishes'));
    }

    public function public()
    {
        $wishes = Wish::where('is_private', false)
            ->where('status', 'open')
            ->with('user')
            ->latest()
            ->get();

        return view('wishes.public', compact('wishes'));
    }
}
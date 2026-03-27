<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
    Route::get('/friends/requests', [FriendshipController::class, 'requests'])->name('friends.requests');
    Route::post('/friends', [FriendshipController::class, 'store'])->name('friends.store');
    Route::patch('/friends/{friendship}/accept', [FriendshipController::class, 'accept'])->name('friends.accept');

    Route::patch('/wishes/{wish}/reserve', [WishController::class, 'reserve'])->name('wishes.reserve');
    Route::patch('/wishes/{wish}/fulfill', [WishController::class, 'fulfill'])->name('wishes.fulfill');

    Route::get('/wishes/{user}', [WishController::class, 'show'])->name('wishes.show');
    
    Route::get('/dashboard', [WishController::class, 'index'])->name('dashboard');
    Route::post('/wishes', [WishController::class, 'store'])->name('wishes.store');
    Route::delete('/wishes/{wish}', [WishController::class, 'destroy'])->name('wishes.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';    
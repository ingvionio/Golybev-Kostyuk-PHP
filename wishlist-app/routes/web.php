<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ErrorReportController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/explore', [WishController::class, 'public'])->name('wishes.public');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [WishController::class, 'index'])->name('dashboard');
    Route::get('/wishes/{user}', [WishController::class, 'show'])->name('wishes.show');
    Route::post('/wishes', [WishController::class, 'store'])->name('wishes.store');
    Route::delete('/wishes/{wish}', [WishController::class, 'destroy'])->name('wishes.destroy');
    Route::get('/wishes/{wish}/edit', [WishController::class, 'edit'])->name('wishes.edit');
    Route::patch('/wishes/{wish}', [WishController::class, 'update'])->name('wishes.update');

    Route::patch('/wishes/{wish}/reserve', [WishController::class, 'reserve'])->name('wishes.reserve');
    Route::patch('/wishes/{wish}/fulfill', [WishController::class, 'fulfill'])->name('wishes.fulfill');

    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
    Route::get('/friends/requests', [FriendshipController::class, 'requests'])->name('friends.requests');
    Route::post('/friends', [FriendshipController::class, 'store'])->name('friends.store');
    Route::patch('/friends/{friendship}/accept', [FriendshipController::class, 'accept'])->name('friends.accept');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');


    Route::middleware(['can:admin-access'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/reports/{id}/reply', [AdminController::class, 'replyToReport'])->name('admin.report.reply');
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
    });
});

require __DIR__.'/auth.php';

Route::post('/error-report', [ErrorReportController::class, 'store'])->name('error.report');
Route::fallback(function () {
    abort(404);
});
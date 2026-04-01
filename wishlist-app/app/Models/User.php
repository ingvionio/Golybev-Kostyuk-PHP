<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class, 
        ];
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }

    public function friendships(): HasMany
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function friends()
    {
        return $this->hasMany(Friendship::class, 'user_id')
            ->where('status', 'accepted');
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }
}
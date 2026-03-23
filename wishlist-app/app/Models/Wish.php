<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $fillable = ['title', 'link', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

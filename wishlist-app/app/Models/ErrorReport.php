<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorReport extends Model
{
    protected $fillable = [
        'user_id', 'error_message', 'user_comment', 'admin_reply', 'status', 'file_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Enums;

enum Role: string {
    case USER = 'user';
    case EDITOR = 'editor';
    case ADMIN = 'admin';
}
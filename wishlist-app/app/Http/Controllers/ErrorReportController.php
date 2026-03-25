<?php

namespace App\Http\Controllers;

use App\Models\ErrorReport;
use Illuminate\Http\Request;

class ErrorReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_comment' => 'required|string|max:1000',
            'error_message' => 'nullable|string'
        ]);

        ErrorReport::create([
            'user_id' => auth()->id(), // null, если отправляет гость
            'error_message' => $request->error_message,
            'user_comment' => $request->user_comment,
        ]);

        return back()->with('success', 'Отчет об ошибке успешно отправлен. Мы скоро все починим!');
    }
}
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
            'error_message' => 'nullable|string',
            'screenshot' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $filePath = null;
        if ($request->hasFile('screenshot')) {
            $filePath = $request->file('screenshot')->store('errors', 'public');
        }

        ErrorReport::create([
            'user_id' => auth()->id(),
            'error_message' => $request->error_message,
            'user_comment' => $request->user_comment,
            'file_path' => $filePath,
        ]);

        // Если юзер авторизован - кидаем в ЛК, если гость - на главную
        if (auth()->check()) {
            return redirect()->route('dashboard')->with('success', 'Отчет об ошибке успешно отправлен!');
        }
        
        return redirect('/')->with('success', 'Отчет об ошибке успешно отправлен!');
    }
}
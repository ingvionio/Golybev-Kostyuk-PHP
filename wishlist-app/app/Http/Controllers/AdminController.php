<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Http\Request;
use SupportModule\ReportManager;

class AdminController extends Controller
{
    // Внедряем зависимость (DI) через конструктор
    public function __construct(private ReportManager $reportManager) {}

    public function index() 
    {
        $users = User::all();
        $reports = $this->reportManager->getAllReports();

        return view('admin.index', compact('users', 'reports'));
    }

    // Метод для ответа на ошибку
    public function replyToReport(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $this->reportManager->replyToReport((int) $id, $request->admin_reply);

        return back()->with('success', 'Ответ на отчет успешно отправлен.');
    }
}
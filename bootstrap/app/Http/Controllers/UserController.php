<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Главная страница личного кабинета (список заявлений пользователя)
    public function dashboard()
    {
        $reports = Report::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('reports'));
    }

    // Форма создания нового заявления
    public function createReport()
    {
        $categories = Category::all();
        return view('user.create_report', compact('categories'));
    }

    // Сохранение заявления в базу данных
    public function storeReport(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_incident' => 'required|date|before_or_equal:today',
            'contact' => 'required|in:Email,SMS',
        ], [
            'date_incident.before_or_equal' => 'Дата происшествия не может быть в будущем.',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'date_incident' => $request->date_incident,
            'contact' => $request->contact,
            'status' => 'new',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Заявление успешно подано!');
    }

    // Удаление заявления
    public function destroyReport($id)
    {
        $report = Report::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($report->status !== 'new') {
            return back()->with('error', 'Можно удалять только заявления в статусе "Новое".');
        }

        $report->delete();
        return redirect()->route('user.dashboard')->with('success', 'Заявление удалено.');
    }
}
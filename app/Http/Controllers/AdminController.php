<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminController extends Controller
{
    // Тот самый метод, который потерялся:
    public function dashboard(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Доступ запрещен.');
        }

        $query = Report::with(['user', 'category'])->orderBy('created_at', 'desc');

        if ($request->has('status') && in_array($request->status, ['new', 'resolved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $reports = $query->get();
        return view('admin.dashboard', compact('reports'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Доступ запрещен.');
        }

        $request->validate([
            'status' => 'required|in:resolved,rejected',
            'review' => 'required_if:status,rejected|string|nullable',
        ], [
            'review.required_if' => 'При отклонении заявления необходимо указать причину.',
        ]);

        $report = Report::findOrFail($id);
        $report->status = $request->status;
        
        if ($request->status === 'rejected') {
            $report->review = $request->review;
        }

        $report->save();

        return redirect()->back()->with('success', 'Статус заявления успешно обновлен!');
    }
}
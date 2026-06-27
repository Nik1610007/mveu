@extends('layouts.app')
@section('title', 'Панель администратора')

@section('content')
<h2>Панель администратора: Модерация заявлений</h2>

<div style="background: #f8fafc; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
    <form action="{{ route('admin.dashboard') }}" method="GET" style="display: flex; gap: 15px; align-items: center;">
        <label><strong>Фильтр по статусу:</strong></label>
        <select name="status" onchange="this.form.submit()" style="padding: 6px; width: auto;">
            <option value="">Все заявления</option>
            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новые</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Решенные</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Отклоненные</option>
        </select>
    </form>
</div>

@if($reports->isEmpty())
    <p>Заявлений не найдено.</p>
@else
    <table style="width: 100%; border-collapse: collapse; background: white;">
        <thead>
            <tr style="background: #e2e8f0; text-align: left;">
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Пользователь</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Данные нарушения</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Статус</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <strong>{{ $report->user->fio }}</strong><br>
                        <small>Тел: {{ $report->user->phone }}</small>
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <strong>{{ $report->title }}</strong> ({{ $report->category->name }})<br>
                        <p style="margin: 5px 0; font-size: 14px;">{{ $report->description }}</p>
                        @if($report->status === 'rejected')
                            <div style="color: #dc2626; margin-top: 5px; font-size: 13px;"><strong>Отказ:</strong> {{ $report->review }}</div>
                        @endif
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        @if($report->status === 'new') <span class="badge badge-new">Новое</span>
                        @elseif($report->status === 'resolved') <span class="badge badge-resolved">Решено</span>
                        @else <span class="badge badge-rejected">Отклонено</span> @endif
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; min-width: 180px;">
                        @if($report->status === 'new')
                            <form action="{{ route('admin.report.status', $report->id) }}" method="POST" style="display:inline-block; margin-bottom: 5px;">
                                @csrf
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="btn" style="background: #10b981; padding: 5px 10px; font-size: 12px;">✅ Решить</button>
                            </form>
                            <form action="{{ route('admin.report.status', $report->id) }}" method="POST" style="margin-top: 5px;">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <input type="text" name="review" placeholder="Причина отказа" required style="padding: 4px; font-size: 12px; margin-bottom: 4px; width: 100%;">
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px; width: 100%;">❌ Отклонить</button>
                            </form>
                        @else
                            <span style="color: #94a3b8; font-size: 12px;">Готово</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
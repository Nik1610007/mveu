@extends('layouts.app')
@section('title', 'Личный кабинет')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Личный кабинет пользователя: {{ Auth::user()->fio }}</h2>
    <a href="{{ route('user.report.create') }}" class="btn">➕ Подать новое заявление</a>
</div>

<h3>Мои заявления</h3>

@if($reports->isEmpty())
    <p>Вы еще не подали ни одного заявления.</p>
@else
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px; background: white;">
        <thead>
            <tr style="background: #e2e8f0; text-align: left;">
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Номер</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Название / Категория</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Описание</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Дата нарушения</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Статус</th>
                <th style="padding: 10px; border: 1px solid #cbd5e1;">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">№ {{ $report->id }}</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <strong>{{ $report->title }}</strong><br>
                        <small style="color: #64748b;">{{ $report->category->name }}</small>
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">{{ $report->description }}</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">{{ \Carbon\Carbon::parse($report->date_incident)->format('d.m.Y') }}</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        @if($report->status === 'new')
                            <span class="badge badge-new">Новое</span>
                        @elseif($report->status === 'resolved')
                            <span class="badge badge-resolved">Решено</span>
                        @else
                            <span class="badge badge-rejected">Отклонено</span>
                        @endif
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        @if($report->status === 'new')
                            <form action="{{ route('user.report.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить заявление?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Удалить</button>
                            </form>
                        @else
                            <span style="color: #94a3b8; font-size: 12px;">Недоступно</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
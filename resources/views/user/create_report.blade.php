@extends('layouts.app')
@section('title', 'Подача заявления')

@section('content')
<h2>Подача заявления о правонарушении</h2>
<p><a href="{{ route('user.dashboard') }}" style="color: #2563eb;">← Вернуться назад</a></p>

<form action="{{ route('user.report.store') }}" method="POST" style="margin-top: 20px;">
    @csrf
    
    <div class="form-group">
        <label>Категория нарушения:</label>
        <select name="category_id" required>
            <option value="" disabled selected>Выберите категорию...</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Автомобильный номерной знак или название нарушения:</label>
        <input type="text" name="title" value="{{ old('title') }}" placeholder="Например: А123АА77" required>
    </div>

    <div class="form-group">
        <label>Описание ситуации:</label>
        <textarea name="description" rows="5" placeholder="Опишите подробно правонарушение..." required>{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label>Дата правонарушения:</label>
        <input type="date" name="date_incident" value="{{ old('date_incident') }}" max="{{ date('Y-m-d') }}" required>
    </div>

    <div class="form-group">
        <label>Уведомить о результате по:</label>
        <select name="contact" required>
            <option value="Email" {{ old('contact') == 'Email' ? 'selected' : '' }}>Email</option>
            <option value="SMS" {{ old('contact') == 'SMS' ? 'selected' : '' }}>SMS</option>
        </select>
    </div>

    <button type="submit" class="btn">🚀 Отправить заявление</button>
</form>
@endsection
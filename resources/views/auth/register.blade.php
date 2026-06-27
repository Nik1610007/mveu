@extends('layouts.app')
@section('title', 'Регистрация')

@section('content')
<h2>Регистрация нового пользователя</h2>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>ФИО (только кириллица):</label>
        <input type="text" name="fio" value="{{ old('fio') }}" required>
    </div>
    <div class="form-group">
        <label>Логин:</label>
        <input type="text" name="login" value="{{ old('login') }}" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
        <label>Телефон:</label>
        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+7(XXX)XXX-XX-XX" required>
    </div>
    <div class="form-group">
        <label>Пароль (минимум 6 символов):</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Подтверждение пароля:</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit" class="btn">Зарегистрироваться</button>
</form>
@endsection
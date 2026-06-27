@extends('layouts.app')
@section('title', 'Вход')

@section('content')
<h2>Авторизация</h2>
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Логин:</label>
        <input type="text" name="login" value="{{ old('login') }}" required>
    </div>
    <div class="form-group">
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" class="btn">Войти</button>
</form>
@endsection
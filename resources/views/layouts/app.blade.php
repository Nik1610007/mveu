<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Нарушениям.Нет</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f6f9; color: #333; }
        header { background: #1e293b; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; margin-left: 15px; font-weight: bold; }
        main { max-width: 1000px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        footer { text-align: center; padding: 20px; color: #666; margin-top: 50px; font-size: 14px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { background: #2563eb; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-danger { background: #dc2626; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-success { background: #d1e7dd; color: #0f5132; }
        .alert-danger { background: #f8d7da; color: #842029; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: #fff; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .badge-new { background: #f59e0b; }
        .badge-resolved { background: #10b981; }
        .badge-rejected { background: #ef4444; }
    </style>
</head>
<body>

<header>
    <div><a href="{{ route('home') }}" style="margin:0; font-size: 20px;">🚨 Нарушениям.Нет</a></div>
    <nav>
        <a href="{{ route('home') }}">Главная</a>
        @auth
            <a href="{{ route('user.dashboard') }}">Личный кабинет</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @else
            <a href="{{ route('login') }}">Вход</a>
            <a href="{{ route('register') }}">Регистрация</a>
        @endauth
    </nav>
</header>

<main>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    @yield('content')
</main>

<footer>
    &copy; {{ date('Y') }} Нарушениям.Нет. Все права защищены (Демо-вариант).
</footer>

</body>
</html>
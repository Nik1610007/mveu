@extends('layouts.app')
@section('title', 'Главная')

@section('content')
<!-- Стили для слайдера (вставляем прямо сюда, чтобы не искать файлы) -->
<style>
    .slider-container {
        position: relative;
        max-width: 100%;
        height: 350px;
        margin-bottom: 30px;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .slide {
        display: none;
        width: 100%;
        height: 100%;
        position: relative;
    }
    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .slide-text {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 20px;
        text-align: center;
    }
    .slide-text h2 { margin: 0 0 5px 0; font-size: 24px; color: #38bdf8; }
    .slide-text p { margin: 0; font-size: 16px; }
    
    /* Кнопки навигации по слайдам */
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 12px 16px;
        cursor: pointer;
        font-size: 18px;
        border-radius: 4px;
        transition: 0.3s;
    }
    .slider-btn:hover { background: rgba(0,0,0,0.8); }
    .prev { left: 10px; }
    .next { right: 10px; }
</style>

<!-- Разметка слайдера -->
<div class="slider-container">
    <!-- Слайд 1 -->
    <div class="slide">
        <img src="{{ asset('images/slider-1.jpg') }}" alt="Слайд 1">
        <div class="slide-text">
            <h2>Фиксируйте нарушения ПДД</h2>
            <p>Нелегальная парковка и перекрытие проездов мешают скорой помощи и жителям.</p>
        </div>
    </div>

    <!-- Слайд 2 -->
    <div class="slide">
        <img src="{{ asset('images/slider-2.jpg') }}" alt="Слайд 2">
        <div class="slide-text">
            <h2>Ямы и разрушенный асфальт</h2>
            <p>Подайте заявление, и городские службы оперативно отремонтируют дорожное покрытие.</p>
        </div>
    </div>

    <!-- Слайд 3 -->
    <div class="slide">
        <img src="{{ asset('images/slider-3.jpg') }}" alt="Слайд 3">
        <div class="slide-text">
            <h2>Сделаем город чище вместе</h2>
            <p>Сообщайте о несанкционированных свалках и горах мусора во дворах.</p>
        </div>
    </div>

    <!-- Кнопки управления -->
    <button class="slider-btn prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="slider-btn next" onclick="changeSlide(1)">&#10095;</button>
</div>

<!-- Блок с логотипом под слайдером -->
<div style="text-align: center; margin-bottom: 40px;">
    <img src="{{ asset('images/logo.png') }}" alt="Логотип" style="max-height: 60px;">
    <p style="color: #475569; font-size: 16px; margin-top: 5px;">Официальный портал мониторинга городских проблем</p>
    @guest
        <p><a href="{{ route('register') }}" class="btn">Зарегистрироваться и подать жалобу</a></p>
    @endguest
</div>

<h3>Последние решенные проблемы 🛠️</h3>

@if($reports->isEmpty())
    <p style="color: #64748b; font-style: italic;">Здесь будут отображаться заявления, которые успешно прошли модерацию администратора.</p>
@else
    <div class="card-grid">
        @foreach($reports as $report)
            <div class="card">
                <span class="badge badge-resolved" style="float: right;">Решено</span>
                <h4 style="margin: 0 0 10px 0; color: #1e293b;">{{ $report->title }}</h4>
                <p style="font-size: 14px; color: #475569; margin: 0 0 10px 0;">{{ Str::limit($report->description, 80) }}</p>
                <small style="color: #94a3b8; display: block; margin-top: 10px;">Категория: {{ $report->category->name }}</small>
            </div>
        @endforeach
    </div>
@endif

<!-- JavaScript логика автоматического переключения слайдов -->
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        if (index >= slides.length) currentSlide = 0;
        else if (index < 0) currentSlide = slides.length - 1;
        else currentSlide = index;

        slides.forEach(slide => slide.style.display = 'none');
        slides[currentSlide].style.display = 'block';
    }

    function changeSlide(direction) {
        showSlide(currentSlide + direction);
    }

    // Инициализация и автопереключение каждые 4 секунды
    showSlide(currentSlide);
    setInterval(() => changeSlide(1), 4000);
</script>
@endsection
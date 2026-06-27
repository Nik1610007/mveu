<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Models\Report;

// Главная страница (просмотр последних 4 решенных заявлений)
Route::get('/', function () {
    $reports = Report::where('status', 'resolved')
        ->with('category')
        ->orderBy('updated_at', 'desc')
        ->take(4)
        ->get();
    return view('welcome', compact('reports'));
})->name('home');

// Гостевые маршруты (Авторизация и Регистрация)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Маршрут для выхода (доступен только авторизованным)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Личный кабинет пользователя (защищен middleware 'auth')
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/report/create', [UserController::class, 'createReport'])->name('report.create');
    Route::post('/report/store', [UserController::class, 'storeReport'])->name('report.store');
    Route::delete('/report/{id}', [UserController::class, 'destroyReport'])->name('report.destroy');
});

// Админ-панель (защищена middleware 'auth')
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/report/{id}/status', [AdminController::class, 'updateStatus'])->name('report.status');
});
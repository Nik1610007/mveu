<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'fio' => 'required|string|regex:/^[а-яА-ЯёЁ\s\-]+$/u|max:255',
            'login' => 'required|string|unique:users,login|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'fio.regex' => 'ФИО может содержать только кириллицу, пробелы и дефисы.',
            'login.unique' => 'Такой логин уже занят.',
            'email.unique' => 'Такой Email уже зарегистрирован.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        $user = User::create([
            'fio' => $request->fio,
            'login' => $request->login,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('user.dashboard');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['login' => 'Неверный логин или пароль.'])->onlyInput('login');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
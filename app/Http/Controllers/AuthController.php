<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (!Auth::attempt($credentials, $request->boolean('remember'))) return back()->withErrors(['email' => 'The provided credentials are incorrect.'])->onlyInput('email');
        $request->session()->regenerate();
        return redirect()->intended(route('tasks.index'));
    }
    public function showRegister() { return view('auth.register'); }
    public function register(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100'], 'email' => ['required', 'email', 'max:255', 'unique:users'], 'password' => ['required', 'confirmed', 'min:8']]);
        $user = User::create($data);
        Auth::login($user);
        return redirect()->route('tasks.index');
    }
    public function logout(Request $request)
    {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }
}

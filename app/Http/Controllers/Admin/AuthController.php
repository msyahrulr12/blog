<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public $module = 'admin.auth';

    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $input = $request->all();
        
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']], $input['remember_me'] ?? '')) {
            $request->session()->regenerate();

            Alert::success('Login Success!', 'Welcome, '.auth()->user()->name);
            return redirect()->route('admin.dashboard');
        }

        Alert::error('Log in failed!', 'The provided credentials do not match our records.');
        return back();
    }

    public function registerForm()
    {
        return view('admin.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        
        // password different
        if ($input['password'] !== $input['repeat_password']) {
            Alert::error('Register failed!', 'Password and repeat password not same.');
            return back();
        }

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        Alert::success('Register Success!', 'Welcome, '.$user->name);
        return redirect()->route('admin.dashboard');
    }

}

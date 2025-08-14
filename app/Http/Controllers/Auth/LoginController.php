<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function loginFrom()
    {
        $user = User::count();
        if ($user == 0) {
            return redirect()->route('business.getRegister');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->orWhere('email',$request->username)->first();
        if(!$user){
            throw ValidationException::withMessages([
                'username' => 'The provided email address or username is invalid.',
            ]);
        }
        if ($user && password_verify($request->password, $user->password)) {
            auth()->login($user);
            return redirect()->route('home');
        }
        // Handle the login logic, e.g., return an error message
        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCtrl extends Controller
{
    public function register(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('feeds');
    }

    public function showRegisterForm()
    {
        return view('pages.users.register');
    }

    public function login()
    {
        return view('pages.users.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $payload = $request->validated();

        $remember = $payload['remember'] ?? false;

        unset($payload['remember']);

        if (Auth::attempt($payload, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return redirect()
            ->route('login')
            ->withErrors(__('Nous ne pouvons pas vous autoriser à vous connecter'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

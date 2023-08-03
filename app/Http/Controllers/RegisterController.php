<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'last_period_end' => ['required'],
            'average_cycle_length' => ['required'],
            'average_period_length' => ['required'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cycle_length' => $request->average_cycle_length,
            'period_length' => $request->average_period_length,
        ]);

        

        // Redirect to the desired page after successful registration
        return view('index');
    }

    protected function registered(Request $request, $user)
    {
    auth()->login($user);
    return view('index');
    }
}

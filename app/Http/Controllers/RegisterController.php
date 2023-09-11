<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cycle;
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
            'last_period_end' => ['required_without:last_period_start'],
            'average_cycle_length' => ['required'],
            'average_period_length' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cycle_length' => $request->average_cycle_length,
            'period_length' => $request->average_period_length,
        ]);

        if ($request['last_period_start']) {
            $cycleStart = $request['last_period_start'];
            $periodStop = date('Y-m-d', strtotime("-1 day", strtotime("+{$request['average_period_length']} days", strtotime($cycleStart))));
            $ovulation = date('Y-m-d', strtotime("-14 days", strtotime($cycleStart)));
            $cycleEnd = date('Y-m-d', strtotime("{$request['average_cycle_length']} days", strtotime($cycleStart)));

            Cycle::create([
                'user_id' => $user->id,
                'cycle_start' => $cycleStart,
                'period_stop' => $periodStop,
                'ovulation' => $ovulation,
                'cycle_end' => $cycleEnd,
            ]);
        } else {
            $periodStop = $request['last_period_end'];
            $cycleStart = date('Y-m-d', strtotime("+1 day", strtotime("-{$request['average_period_length']} days", strtotime($periodStop))));
            $ovulation = date('Y-m-d', strtotime("-14 days", strtotime($cycleStart)));
            $cycleEnd = date('Y-m-d', strtotime("{$request['average_cycle_length']} days", strtotime($cycleStart)));

            Cycle::create([
                'user_id' => $user->id,
                'cycle_start' => $cycleStart,
                'period_stop' => $periodStop,
                'ovulation' => $ovulation,
                'cycle_end' => $cycleEnd,
            ]);
        }

        auth()->login($user);
        // Redirect to the desired page after successful registration
        return redirect()->route('index');
    }

}

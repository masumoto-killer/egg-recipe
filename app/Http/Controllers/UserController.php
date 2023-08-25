<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function viewProfile(User $user)
    {
        $user = auth()->user();
        return view('profile',['user' => $user,]);
    }

    public function updateUserCycle(User $user)
    {
        $user = auth()->user();
        $recentCycles = Cycle::where('user_id', $user->id)->orderBy('cycle_end','desc')->take(3)->get();
        $periodLengthSum = 0;
        $cycleLengthSum = 0;
        $count = 0;
        foreach ($recentCycles as $cycle) {
            $periodLengthSum += (Carbon::parse($cycle->period_stop)->diffInDays($cycle->cycle_start));
            $cycleLengthSum += (Carbon::parse($cycle->cycle_end)->diffInDays($cycle->cycle_start));
            $count ++;
        }
        $user->period_length = round($periodLengthSum / $count);
        $user->cycle_length = round($cycleLengthSum / $count);
        $user->save();
        return $user;
    }
}

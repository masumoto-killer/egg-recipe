<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cycle;
use Carbon\Carbon;
use App\Http\Controllers\CycleController;

class UserController extends Controller
{
    public function viewProfile(User $user)
    {
        $user = auth()->user();
        return view('profile',['user' => $user,]);
    }

    public static function updateCycleInfo(User $user)
    {
        $forecastCycles = Cycle::where('user_id', $user->id)->where('cycle_start','>',Carbon::today());
        $forecastCycles->delete();

        $recentCycles = Cycle::where('user_id', $user->id)->where('cycle_end','<=',Carbon::today())->orderBy('cycle_end','desc')->take(6)->get();
        if ($recentCycles) {
            $periodLengthSum = 0;
            $cycleLengthSum = 0;
            foreach ($recentCycles as $cycle) {
                $periodLengthSum += (Carbon::parse($cycle->period_stop)->diffInDays($cycle->cycle_start)) +1;
                $cycleLengthSum += (Carbon::parse($cycle->cycle_end)->diffInDays($cycle->cycle_start));
            }
            $user->period_length = round($periodLengthSum / count($recentCycles));
            $user->cycle_length = round($cycleLengthSum / count($recentCycles));
            $user->save();
            return $user;
        }
    }
}

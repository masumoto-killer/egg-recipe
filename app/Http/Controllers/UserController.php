<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cycle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CycleController;
use App\Mail\EmailNotification;

class UserController extends Controller
{
    public function viewProfile()
    {
        $user = auth()->user();
        return view('profile',['user' => $user,]);
    }

    public static function updateCycleInfo(User $user)
    {
        $forecastCycles = Cycle::where('user_id', $user->id)->where('cycle_start','>',Carbon::today());
        $forecastCycles->delete();

        $recentCycles = Cycle::where('user_id', $user->id)->where('cycle_end','<=',Carbon::today())->orderBy('cycle_end','desc')->take(6)->get();
        if (count($recentCycles) != 0) {
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

    public function setEmailNotification(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'mail_date' => $request->input('mail_date'),
            'mail_time' => $request->input('mail_time'),
        ]);
        return redirect()->route('profile');
    }

    public function sendEmail(User $user): RedirectResponse
    {
        Mail::to($user)->later(today()->setTimeFromTimeString($user->mail_time), (new EmailNotification($user))->subject('Egg Recipe: Chu kỳ mới sắp bắt đầu')->view('notification'));

        return 0;
    }

    public function testSendEmail()
    {
        $user = auth()->user();
        Mail::to($user)->send((new EmailNotification($user))->view('notification'));

        return redirect()->route('profile');
    }
    
}

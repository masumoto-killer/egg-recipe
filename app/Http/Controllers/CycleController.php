<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cycle;
use Illuminate\Support\Carbon;

class CycleController extends Controller
{
    public function createCycle(User $user)
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Get the latest cycle of the user
        $latestCycle = Cycle::where('user_id', $user->id)->latest('cycle_end')->first();

        // Calculate the new cycle's start and end dates based on the formula
        $newCycleStart = $latestCycle ? Carbon::parse($latestCycle->cycle_end)->addDay() : now();
        $newCycleEnd = Carbon::parse($newCycleStart)->addDays($user->cycle_length);

        // Calculate the period stop date
        $periodStop = Carbon::parse($newCycleStart)->addDays($user->period_length);

        // Calculate the ovulation date (14 days before the cycle start)
        $ovulation = Carbon::parse($newCycleStart)->subDays(14);

        // Create a new cycle record in the database
        $cycle = new Cycle();
        $cycle->user_id = $user->id;
        $cycle->cycle_start = $newCycleStart;
        $cycle->cycle_end = $newCycleEnd;
        $cycle->period_stop = $periodStop;
        $cycle->ovulation = $ovulation;
        $cycle->save();

        // Optionally, you can return the newly created cycle for further processing or display
        return $cycle;
    }

    public function index(User $user)
    {
        if (!$user) {
            return redirect('welcome');
        }
        // Get the authenticated user
        $user = auth()->user();
        // Fetch the authenticated user and their latest cycle (if available)
        $latestCycle = Cycle::where('user_id', $user->id)->latest('cycle_end')->first();
        // Check if the latest cycle's ovulation date is in the past
        while ($latestCycle && Carbon::today()->greaterThan($latestCycle->ovulation)) {
            // Create a new cycle for the user and update the latestCycle variable
            $latestCycle = $this->createCycle($user);
        }
        $currentCycle = Cycle::where('user_id', $user->id)->where('ovulation', '<=', Carbon::today())->latest('cycle_end')->first();
        $nextCycle = Cycle::where('user_id', $user->id)->where('ovulation', '>', Carbon::today())->latest('cycle_end')->first();

        $currentDate = Carbon::today();
        if ($currentDate->between($currentCycle->cycle_start, $currentCycle->period_stop)) {
            $user->status = 'In Period';
        } elseif ($currentDate->between($currentCycle->period_stop, $nextCycle->ovulation)) {
            $user->status = 'Before Ovulation';
        } elseif ($currentDate->between($nextCycle->ovulation, $currentCycle->cycle_end)) {
            $user->status = 'Before Period';
        } elseif ($currentDate->equalTo($currentCycle->cycle_start)) {
            $user->status = 'Period Start';
        } elseif ($currentDate->equalTo($currentCycle->cycle_end)) {
            $user->status = 'Period End';
        } elseif ($currentDate->equalTo($nextCycle->ovulation)) {
            $user->status = 'Ovulation';
        }
        $user->save();

        return view(
            'index',[
                'user' => $user,
                'currentCycle' => $currentCycle,
                'nextCycle' => $nextCycle,
            ]);
        }
}

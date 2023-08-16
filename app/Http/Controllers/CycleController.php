<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    
        // Get the last cycle of the user
        $lastCycle = Cycle::where('user_id', $user->id)->latest('cycle_end')->first();

        // Calculate the new cycle's start and end dates based on the formula
        $newCycleStart = $lastCycle ? Carbon::parse($lastCycle->cycle_end)->addDay() : now();
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

    public function updateCycle(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();
        $currentDate = Carbon::today();

        // Get the current and next cycles of the user
        $currentCycle = Cycle::where('user_id', $user->id)->where('cycle_end', '>=', $currentDate)->orderBy('cycle_end')->first();
        $nextCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '>', $currentDate)->orderBy('cycle_start')->first();
        $nextCycles = Cycle::where('user_id', $user->id)->where('cycle_start', '>', $currentDate)->orderBy('cycle_start')->get();

        // Update the period_stop and cycle_end of the current cycle based on user input
        if ($currentCycle) {
            $currentCycle->update([
                'period_stop' => $request->input('period_stop'),
                'cycle_end' => $request->input('cycle_end'),
            ]);

            // Update user's info using average values from recent cycles
            $recentCycles = Cycle::where('user_id', $user->id)->orderBy('cycle_end', 'desc')->take(3)->get();
            $periodLengthSum = 0;
            $cycleLengthSum = 0;
            foreach ($recentCycles as $cycle) {
                $periodLengthSum += $cycle->period_length;
                $cycleLengthSum += $cycle->cycle_length;
            }
            $user->period_length = round($periodLengthSum / 3);
            $user->cycle_length = round($cycleLengthSum / 3);
            $user->save();

            // Update next cycle's info based on updated current cycle's info
            if ($nextCycle) {
                $nextCycle->update([
                    'cycle_start' => $currentCycle->cycle_end,
                    'period_stop' => $currentCycle->cycle_end->addDays($user->period_length),
                    'ovulation' => $currentCycle->cycle_end->subDays(14),
                    'cycle_end' => $currentCycle->cycle_end->addDays($user->cycle_length),
                ]);
            }
            foreach ($nextCycles as $cycle) {
                $nextCycleStart = $cycle->cycle_end;
                $nextPeriodStop = $nextCycleStart->addDays($user->period_length);
                $nextOvulation = $nextCycleStart->subDays(14);
                $nextCycleEnd = $nextCycleStart->addDays($user->cycle_length);
        
                $cycle->update([
                    'cycle_start' => $nextCycleStart,
                    'period_stop' => $nextPeriodStop,
                    'ovulation' => $nextOvulation,
                    'cycle_end' => $nextCycleEnd,
                ]);
            }                
        }

        // Redirect back
        return redirect()->back();
    }

    public function index(User $user)
    {
        if (!$user) {
            return redirect('welcome');
        }
        // Get the authenticated user and current date
        $user = auth()->user();
        $currentDate = Carbon::today();
        $cycles = Cycle::where('user_id', $user->id)->get();

        // Fetch the authenticated user and their last cycle (if available)
        $lastCycle = Cycle::where('user_id', $user->id)->latest('cycle_end')->first();

        // Check if the last cycle's ovulation date is in the past
        while ($lastCycle && Carbon::parse($lastCycle->ovulation)->diffInDays($currentDate) < 180) {
            // Create a new cycle for the user and update the lastCycle variable
            $lastCycle = $this->createCycle($user);
        }

        $currentCycle = Cycle::where('user_id', $user->id)->where('cycle_end', '>=', $currentDate)->orderBy('cycle_end')->first();
        $nextCycle = Cycle::where('user_id', $user->id)->where('ovulation', '>', $currentDate)->orderBy('ovulation')->first();

        if ($currentDate->equalTo($currentCycle->cycle_start)) {
            $user->status = '0';
        } elseif ($currentDate->equalTo($currentCycle->cycle_end)) {
            $user->status = '2';
        } elseif ($currentDate->equalTo($nextCycle->ovulation)) {
            $user->status = '4';
        } elseif ($currentDate->between($currentCycle->cycle_start, $currentCycle->period_stop)) {
            $user->status = '1';
        } elseif ($currentDate->between($currentCycle->period_stop, $nextCycle->ovulation)) {
            $user->status = '3';
        } elseif ($currentDate->between($nextCycle->ovulation, $currentCycle->cycle_end)) {
            $user->status = '5';
        }
        $user->save();

        return view(
            'index',[
                'user' => $user,
                'cycles' => $cycles,
                'currentCycle' => $currentCycle,
                'nextCycle' => $nextCycle,
                'lastCycle' => $lastCycle
            ]);
        }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cycle;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Carbon;
use App\Http\Controllers\UserController;

class CycleController extends Controller
{
    public function create()
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Get the last cycle of the user
        $lastCycle = Cycle::where('user_id', $user->id)->latest('cycle_end')->first();

        // Calculate the new cycle's start and end dates based on the formula
        $newCycleStart = Carbon::parse($lastCycle->cycle_end);
        $newCycleEnd = Carbon::parse($newCycleStart)->addDays($user->cycle_length);
        $periodStop = Carbon::parse($newCycleStart)->addDays($user->period_length)->subDays(1);
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

    public function add(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Create a new cycle with the provided cycle_start and period_stop
        $newCycle = new Cycle([
            'user_id' => $user->id,
            'cycle_start' => $request->input('cycle_start'),
            'period_stop' => $request->input('period_stop'),
            'ovulation' => Carbon::parse($request->input('cycle_start'))->subDays(14),
            'cycle_end' => Carbon::parse($request->input('cycle_start'))->addDays($user->cycle_length)->subDays(1)
        ]);

        // Save the new cycle
        $newCycle->save();

        // Update the previous cycle's cycle_end (if it exists)
        $previousCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '<', $newCycle->cycle_start)->orderBy('cycle_start', 'desc')->first();
        if ($previousCycle) {
            $previousCycle->cycle_end = $newCycle->cycle_start;
            $previousCycle->save();
        }

        // Update the next cycle's cycle_start (if it exists)
        $nextCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '>', $newCycle->cycle_start)->orderBy('cycle_start')->first();
        if ($nextCycle) {
            $newCycle->cycle_end = $nextCycle->cycle_start;
            $newCycle->save();
        }

        $user = User::find($user->id);
        UserController::updateCycleInfo($user);

        return redirect()->route('edit');
    }

    public function update(Request $request, $id)
    {
        // Find the cycle by ID
        $cycle = Cycle::findOrFail($id);
        $user = User::find($cycle->user_id);

        // Update the current cycle
        $cycle->update([
            'cycle_start' => $request->input('cycle_start'),
            'period_stop' => $request->input('period_stop'),
            'ovulation' => Carbon::parse($request->input('cycle_start'))->subDays(14),
            'cycle_end' => Carbon::parse($request->input('cycle_start'))->addDays($user->cycle_length),
        ]);

        // Update the previous cycle's cycle_end (if it exists)
        $previousCycle = Cycle::where('user_id', $user->id)->where('cycle_end', '<=', $cycle->cycle_start)->latest('cycle_end')->first();
        if ($previousCycle) {
            $previousCycle->cycle_end = $cycle->cycle_start;
            $previousCycle->save();
        }

        // Update the next cycle's cycle_start (if it exists)
        $nextCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '>=', $cycle->cycle_end)->oldest('cycle_start')->first();
        if ($nextCycle) {
            $cycle->cycle_end = $nextCycle->cycle_start;
            $cycle->save();
        }

        // Update user's info using average values from recent cycles
        UserController::updateCycleInfo($user);

        return redirect()->route('edit');
    }

    public function delete($id)
    {
        // Find the cycle by ID
        $cycle = Cycle::findOrFail($id);
        $user = User::find($cycle->user_id);

        $previousCycle = Cycle::where('user_id', $user->id)->where('cycle_end', '<=', $cycle->cycle_start)->latest('cycle_end')->first();
        $nextCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '>=', $cycle->period_stop)->oldest('cycle_start')->first();
        if ($previousCycle && $nextCycle) {
            $previousCycle->cycle_end = $nextCycle->cycle_start;
            $previousCycle->save();
        }

        // Delete the cycle
        $cycle->delete();

        UserController::updateCycleInfo($user);

        return redirect()->route('edit');
    }

    public function edit()
    {
        // Fetch the user's cycles, ordered by date
        $cycles = Cycle::where('user_id', auth()->user()->id)
        ->where('cycle_start','<=',Carbon::today())->orderBy('cycle_start', 'desc')->get();
        return view('edit', compact('cycles'));
    }

    public function index()
    {
        // Get the authenticated user and current date
        $user = auth()->user();
        $currentDate = Carbon::today();

        // Fetch the authenticated user and their last cycle (if available)
        $lastCycle = Cycle::where('user_id', $user->id)->latest('cycle_end')->first();
        $currentCycle = Cycle::where('user_id', $user->id)->where('cycle_end', '>', $currentDate)->orderBy('cycle_end')->first();

        // Check if the last cycle's ovulation date is in the past
        while ($lastCycle && Carbon::parse($lastCycle->ovulation)->diffInDays($currentDate) < 180) {
            // Create a new cycle for the user and update the lastCycle variable
            $lastCycle = $this->create($user);
        }

        $nextCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '>', $currentDate)->orderBy('cycle_start')->first();

        if ($currentDate->equalTo($currentCycle->cycle_start)) {
            $user->status = '0';
            $message = "Có thể bắt đầu chu kỳ hôm nay";
        } elseif ($currentDate->equalTo($currentCycle->period_stop)) {
            $user->status = '2';
            $message = "Có thể kết thúc chu kỳ hôm nay";
        } elseif ($currentDate->between($currentCycle->cycle_start, $currentCycle->period_stop)) {
            $user->status = '1';
            $daysLeft = Carbon::parse($currentCycle->period_stop)->diffInDays($currentDate);
            $message = "Có thể kết thúc chu kỳ sau $daysLeft ngày.";
        } elseif ($currentDate->between($currentCycle->period_stop, $currentCycle->cycle_end)) {
            $user->status = '3';
            $daysLeft = Carbon::parse($nextCycle->cycle_start)->diffInDays($currentDate);
            $message = "Có thể bắt đầu chu kỳ sau $daysLeft ngày.";
        }
        $user->save();
        $cycles = Cycle::where('user_id', $user->id)->get();

        return view(
            'index',[
                'user' => $user,
                'cycles' => $cycles,
                'currentCycle' => $currentCycle,
                'nextCycle' => $nextCycle,
                'lastCycle' => $lastCycle,
                'message' => $message
            ]
        );
    }

    public function addToGoogleCalendar($id) {
        $cycle = Cycle::findOrFail($id);
        $user = User::find($cycle->user_id);

        $event = new Event;
        $event->name = 'Next Egg Recipe';
        $event->startDate = Carbon::parse($cycle->cycle_start);
        $event->endDate = Carbon::parse($cycle->period_stop);
        $event->addAttendee(['email' => $user->email]);
        $event->save();

        $cycle->update(['in_calendar' => true]);
    
        return redirect()->route('index');
    }
    
}

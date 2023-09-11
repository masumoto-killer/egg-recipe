<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserController;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Cycle;
use Illuminate\Support\Carbon;

class SendEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (User::all() as $user) {
            $nextCycle = Cycle::where('user_id', $user->id)->where('cycle_start', '>', Carbon::today())->orderBy('cycle_start')->first();
            if (Carbon::parse($nextCycle->cycle_start)->diffInDays(Carbon::today()) == $user->mail_date) {
                UserController::sendEmail($user);
            }
        }

        return 0;
    }
}

<?php

namespace App\Console;

use App\Models\Holiday;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\Attendence::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $holiday = Holiday::where('date', date('Y-m-d'))->where('status', 1)->first();

        $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
        $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');

        $last_date = date('Y-m-d');

        if (!$holiday && !$sat1 && !$sat3) {
        }
        $schedule->command('attend:data')->everyFifteenMinutes()->weekdays()->between('09:00', '12:00');
        $schedule->command('attend:data')->everyFifteenMinutes()->weekdays()->between('18:00', '23:59');

        if ($last_date == date('Y-m-t')) {
            $schedule->command('salary:manage')->daily()->between('22:00', '1:00');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

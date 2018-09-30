<?php

namespace App\Console;

use App\Jobs\ProcessTumblrImages;
use App\Jobs\ProcessTumblrVideos;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ProcessTumblrImages())->hourly();
        $schedule->job(new ProcessTumblrVideos())->hourly();

        // $uniqueImage = [];

        // Photoset::all()->filter(function ($item) use (&$uniqueImage) {
        //     if (in_array($item->images, $uniqueImage)) {
        //         // address is a duplicate
        //         return $item;
        //     }

        //     $uniqueImage[] = $item->images;
        // })->map(function($photoset) {
        //     $photoset->delete();
        // });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

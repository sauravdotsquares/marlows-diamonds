<?php

namespace App\Console;

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
        Commands\LogCron::class,
        Commands\SitemapCron::class,
        Commands\XmlCrone::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function(){
        //     info('Called Every Minutes before');
        // })->everyMinute()->appendOutputTo(storage_path().'/logs/sitemap_cron1.log');

        // $schedule->command('inspire')->hourly();
        // $schedule->command('demo:crone')->everyFiveMinutes();

        $schedule->command('log:cron')
                 ->everyThirtyMinutes()-> appendOutputTo (storage_path().'/logs/log_cron.log');
        $schedule->command('sitemap:cron')
                 ->daily()->appendOutputTo (storage_path().'/logs/sitemap_cron.log');
        $schedule->command('xml:cron')
                 ->dailyAt('09:00')->appendOutputTo(storage_path().'/logs/xml_crone.log');

        // $schedule->call(function(){
        //     info('Called Every Minutes after');
        // })->everyMinute()->appendOutputTo(storage_path().'/logs/sitemap_cron.log');
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

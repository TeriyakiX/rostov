<?php

namespace App\Console;

use App\Console\Commands\Sundry;
use App\Models\Product;
use App\Notifications\NoveltyExpiredNotification;
use App\Notifications\PromoExpiredNotification;
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
        Sundry::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $products = Product::where('is_novelty', true)
                ->whereDate('end_novelty_date', '<', now())
                ->get();

            foreach ($products as $product) {
                $admins = \App\Models\User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    $admin->notify(new NoveltyExpiredNotification($product));
                }

                $product->update(['is_novelty' => false]);
            }
        })->daily();

        $schedule->call(function () {
            $products = Product::where('is_promo', true)
                ->whereDate('end_promo_date', '<', now())
                ->get();

            foreach ($products as $product) {
                $admins = \App\Models\User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    $admin->notify(new PromoExpiredNotification($product));
                }

                $product->update([
                    'is_promo' => false,
                    'price' => $product->regular_price,
                ]);
            }
        })->daily();
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

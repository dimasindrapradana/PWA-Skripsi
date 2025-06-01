<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\MakeUserWithRole::class, // ⬅️ daftarkan di sini
    ];

    protected function schedule(Schedule $schedule): void
    {
        // jadwal task otomatis (optional)
    }
    protected $routeMiddleware = [
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'admin.only' => \App\Http\Middleware\AdminOnly::class,

    ];


    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}

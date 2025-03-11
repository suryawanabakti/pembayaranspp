<?php

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // $setting = Setting::first();
        // $formattedTime = Carbon::createFromFormat("H:i:s", $setting->jam ?? "00:00:00")->format("H:i");
        // $schedule->command('bill:notify')
        //     ->monthlyOn($setting->tanggal ?? 15, $formattedTime ?? "06:00")->withoutOverlapping();
    })
    ->create();

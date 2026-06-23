<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // === RESPALDO ===
        // Backup automático cada 1.5 semanas (10 días)
        $schedule->command('backup:automatico')
                 ->cron('0 2 */10 * *')
                 ->withoutOverlapping()
                 ->runInBackground()
                 ->appendOutputTo(storage_path('logs/backup-automatico.log'));

        // === SEGURIDAD ===
        // Auditoría automática cada lunes a las 8:00 AM
        $schedule->command('guard:probe --send-email=bolsadeproyectossena@gmail.com')
                 ->mondays()
                 ->at('08:00')
                 ->withoutOverlapping();

        // === MANTENIMIENTO ===
        // Limpieza de datos caducados (tokens, notificaciones, sesiones, logs) - diario 3:00 AM
        $schedule->command('app:cleanup-expired')
                 ->dailyAt('03:00')
                 ->withoutOverlapping()
                 ->runInBackground()
                 ->appendOutputTo(storage_path('logs/cleanup-expired.log'));

        // Optimización de tablas de BD - domingos 4:00 AM
        $schedule->command('app:optimize-database')
                 ->weeklyOn(0, '04:00')
                 ->withoutOverlapping()
                 ->runInBackground()
                 ->appendOutputTo(storage_path('logs/optimize-database.log'));

        // === COLAS ===
        // Monitoreo y recuperación automática de jobs fallidos - cada 30 minutos
        $schedule->command('queue:auto-recover --pending-threshold=50')
                 ->everyThirtyMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/queue-auto-recover.log'));

        // Monitoreo de salud de colas - cada hora
        $schedule->command('queue:monitor')
                 ->hourly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/queue-monitor.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

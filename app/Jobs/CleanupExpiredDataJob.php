<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupExpiredDataJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;
    public int $uniqueFor = 7200;

    public function __construct()
    {
        $this->onQueue('low');
    }

    public function uniqueId(): string
    {
        return 'cleanup_expired_data';
    }

    public function handle(): void
    {
        $this->cleanPasswordResetTokens();
        $this->cleanOldNotifications();
        $this->cleanOldSessions();
        $this->cleanOldAuditLogs();
        $this->cleanExpiredEmailOtps();

        Log::info('CleanupExpiredDataJob completed successfully');
    }

    private function cleanPasswordResetTokens(): void
    {
        $deleted = DB::table('password_reset_tokens')
            ->where('created_at', '<', now()->subHours(24))
            ->delete();

        if ($deleted > 0) {
            Log::info("Cleaned {$deleted} expired password reset tokens");
        }
    }

    private function cleanOldNotifications(): void
    {
        $deleted = DB::table('notifications')
            ->where('read_at', '!=', null)
            ->where('read_at', '<', now()->subDays(30))
            ->delete();

        if ($deleted > 0) {
            Log::info("Cleaned {$deleted} old read notifications");
        }
    }

    private function cleanOldSessions(): void
    {
        $deleted = DB::table('sessions')
            ->where('last_activity', '<', now()->subDays(7)->timestamp)
            ->delete();

        if ($deleted > 0) {
            Log::info("Cleaned {$deleted} expired sessions");
        }
    }

    private function cleanOldAuditLogs(): void
    {
        $deleted = DB::table('audit_logs')
            ->where('created_at', '<', now()->subDays(90))
            ->delete();

        if ($deleted > 0) {
            Log::info("Cleaned {$deleted} old audit logs (>90 days)");
        }
    }

    private function cleanExpiredEmailOtps(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('email_verification_otps')) {
            return;
        }

        $deleted = DB::table('email_verification_otps')
            ->where('expires_at', '<', now())
            ->delete();

        if ($deleted > 0) {
            Log::info("Cleaned {$deleted} expired email OTPs");
        }
    }
}

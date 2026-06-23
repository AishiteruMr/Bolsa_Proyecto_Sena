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

class OptimizeDatabaseJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;
    public int $uniqueFor = 86400;

    public function __construct()
    {
        $this->onQueue('low');
    }

    public function uniqueId(): string
    {
        return 'optimize_database';
    }

    public function handle(): void
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $key = "Tables_in_{$dbName}";
        $optimized = 0;

        foreach ($tables as $table) {
            $tableName = $table->$key;
            try {
                DB::statement("OPTIMIZE TABLE `{$tableName}`");
                $optimized++;
            } catch (\Exception $e) {
                Log::warning("Could not optimize table {$tableName}: {$e->getMessage()}");
            }
        }

        Log::info("OptimizeDatabaseJob completed: {$optimized} tables optimized");
    }
}

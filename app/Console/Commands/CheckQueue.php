<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckQueue extends Command
{
    protected $signature = 'queue:check';
    protected $description = 'Check queue job status';

    public function handle()
    {
        $pending = DB::table('jobs')->count();
        $failed = DB::table('failed_jobs')->count();

        $this->info("Pending jobs: {$pending}");
        $this->info("Failed jobs: {$failed}");

        if ($failed > 0) {
            $this->error("\nFailed jobs:");
            DB::table('failed_jobs')->select('id', 'queue', 'failed_at')->get()->each(function ($job) {
                $this->error("ID: {$job->id}, Queue: {$job->queue}, Failed at: {$job->failed_at}");
            });
        }

        return 0;
    }
}

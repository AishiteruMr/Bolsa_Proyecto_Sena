<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RateLimitedMiddleware
{
    public function __construct(
        private int $maxAttempts = 5,
        private int $decaySeconds = 60,
        private string $prefix = 'job-rate-limit:'
    ) {}

    public function handle(object $job, callable $next): void
    {
        $jobClass = $job::class;
        $key = $this->prefix . $jobClass . ':' . ($job->rateLimitKey ?? '');

        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            $job->release($this->decaySeconds);
            Log::warning("Rate limit reached for " . $jobClass, [
                'key' => $key,
                'attempts' => $attempts,
                'max' => $this->maxAttempts,
                'released_in' => $this->decaySeconds,
            ]);
            return;
        }

        Cache::put($key, $attempts + 1, $this->decaySeconds);

        $next($job);
    }
}

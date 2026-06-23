<?php

namespace App\Jobs;

use App\Jobs\Middleware\RateLimitedMiddleware;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $uniqueFor = 60;
    public int $tries = 3;
    public int $backoff = 10;

    public string $rateLimitKey = '';

    public function __construct(
        private string $email,
        private Mailable $mailable
    ) {
        $this->onQueue('default');
        $this->rateLimitKey = $this->email;
    }

    public function uniqueId(): string
    {
        return 'email:' . $this->email . ':' . md5(serialize($this->mailable));
    }

    public function middleware(): array
    {
        return [new RateLimitedMiddleware(maxAttempts: 10, decaySeconds: 60)];
    }

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send($this->mailable);
        } catch (\Exception $e) {
            Log::error('Error sending email to ' . $this->email . ': ' . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendEmailJob failed permanently for ' . $this->email, [
            'error' => $e->getMessage(),
            'email' => $this->email,
        ]);
    }
}

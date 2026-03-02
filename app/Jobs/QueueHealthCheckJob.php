<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class QueueHealthCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $source,
        public string $reference,
    ) {}

    public function handle(): void
    {
        Log::info('Queue health check processed.', [
            'source' => $this->source,
            'reference' => $this->reference,
            'processed_at' => now()->toDateTimeString(),
        ]);
    }
}

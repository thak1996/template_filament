<?php

namespace App\Jobs;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewLeadNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProcessLeadWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public $backoff = 10;

    public function __construct(public Lead $lead) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Iniciando processamento do Lead ID: {$this->lead->id}");

        Mail::to(config('site.from_email'))
            ->send(new NewLeadNotification($this->lead));

        Log::info("Lead processado com sucesso.");
    }
}

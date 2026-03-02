<?php

namespace App\Console\Commands;

use App\Jobs\QueueHealthCheckJob;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DispatchQueueHealthCheckCommand extends Command
{
    protected $signature = 'queue:health-check';

    protected $description = 'Envia um job de teste para validar o processamento da fila';

    public function handle(): int
    {
        $reference = (string) Str::uuid();

        QueueHealthCheckJob::dispatch('cli', $reference);

        $this->info("Job de teste enviado com referência: {$reference}");
        $this->line('Acompanhe em: docker compose logs -f laravel.worker');

        return self::SUCCESS;
    }
}

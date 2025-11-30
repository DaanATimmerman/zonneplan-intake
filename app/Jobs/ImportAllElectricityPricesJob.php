<?php

namespace App\Jobs;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ImportAllElectricityPricesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $startDate;

    public function __construct(string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        Bus::batch([
            new ImportElectricityPricesPerDateJob($this->startDate),
        ])
            ->name('Import prices')
            ->allowFailures()
            ->then(function (Batch $batch) {
                Cache::forever(ImportAllElectricityPricesJob::class, now()->timestamp);
            })
            ->dispatch();
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            new RateLimited(self::class),
        ];
    }
}

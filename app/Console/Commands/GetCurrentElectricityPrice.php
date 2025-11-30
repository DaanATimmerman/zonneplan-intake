<?php

namespace App\Console\Commands;

use App\Jobs\ImportElectricityPricesPerDateJob;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetCurrentElectricityPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-current-electricity-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current electricity price';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line('Starting fetching current electricity price');

        $startDate = Carbon::now()->format('Y-m-d');

        ImportElectricityPricesPerDateJob::dispatch($startDate);

        $this->line('Finished fetching current electricity price!');
    }
}

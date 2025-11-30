<?php

namespace App\Console\Commands;

use App\Jobs\ImportAllElectricityPricesJob;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetElectricityPriceHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-electricity-price-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a year of electricity price history';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line('Starting fetching of electricity price history... (this may take a while)');

        $startDate = Carbon::now()->subYear()->format('Y-m-d');

        ImportAllElectricityPricesJob::dispatch($startDate);

        $this->line('Job dispatched, check Horizon for current status!');
    }
}

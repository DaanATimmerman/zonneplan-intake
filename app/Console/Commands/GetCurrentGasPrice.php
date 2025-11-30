<?php

namespace App\Console\Commands;

use App\Jobs\ImportCurrentGasPriceJob;
use Illuminate\Console\Command;

class GetCurrentGasPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-current-gas-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current gas price';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line('Starting fetching current gas price');

        ImportCurrentGasPriceJob::dispatch();

        $this->line('Finished fetching current gas price!');
    }
}

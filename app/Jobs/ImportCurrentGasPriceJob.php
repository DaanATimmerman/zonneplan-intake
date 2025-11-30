<?php

namespace App\Jobs;

use App\Http\Facades\Zonneplan;
use App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Data\GasPricesData;
use App\Models\GasPrice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ImportCurrentGasPriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * @var array|int[]
     */
    public array $backoff = [5, 30, 60, 90];

    public function __construct() {}

    /** @return array<int, string> */
    public function tags(): array
    {
        return [
            'gas_price',
        ];
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        Zonneplan::energyPrices()
            ->gasPrices()
            ->gasPricesDataCollection
            ->each(function (GasPricesData $gasPricesRequestData) {
                $start = Carbon::createFromTimestampUTC($gasPricesRequestData->startDate);
                $end = Carbon::createFromTimestampUTC($gasPricesRequestData->endDate);

                GasPrice::updateOrCreate([
                    'start_date' => $start,
                ], [
                    'end_date' => $end,
                    'market_price' => $gasPricesRequestData->marketPrice,
                    'total_price_incl_tax' => $gasPricesRequestData->totalPriceTaxIncluded,
                    'price_incl_handling_vat' => $gasPricesRequestData->priceInclHandlingVat,
                    'price_tax_with_vat' => $gasPricesRequestData->priceTaxWithVat,
                ]);
            });
    }
}

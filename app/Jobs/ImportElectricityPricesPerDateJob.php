<?php

namespace App\Jobs;

use App\Http\Facades\Zonneplan;
use App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Data\ElectricityPricesData;
use App\Models\ElectricityPrice;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ImportElectricityPricesPerDateJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * @var array|int[]
     */
    public array $backoff = [5, 30, 60, 90];

    public function __construct(
        public string $dateString
    ) {}

    /** @return array<int, string> */
    public function tags(): array
    {
        return [
            'electricity_prices',
            $this->dateString,
        ];
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        Zonneplan::energyPrices()
            ->electricityPrices($this->dateString)
            ->electricityPricesDataCollection
            ->each(function (ElectricityPricesData $electricityPricesData) {
                $start = Carbon::createFromTimestampUTC($electricityPricesData->startDate);
                $end = Carbon::createFromTimestampUTC($electricityPricesData->endDate);

                ElectricityPrice::updateOrCreate([
                    'start_date' => $start,
                ], [
                    'end_date' => $end,
                    'market_price' => $electricityPricesData->marketPrice,
                    'total_price_incl_tax' => $electricityPricesData->totalPriceTaxIncluded,
                    'price_incl_handling_vat' => $electricityPricesData->priceInclHandlingVat,
                    'price_tax_with_vat' => $electricityPricesData->priceTaxWithVat,
                    'pricing_profile' => $electricityPricesData->pricingProfile,
                    'carbon_footprint_in_gram' => $electricityPricesData->carbonFootprintInGram,
                    'sustainability_score' => $electricityPricesData->sustainabilityScore,
                ]);
            });

        $nextDate = Carbon::parse($this->dateString)->addDay();

        // continue until we got everything until tomorrow (API goes up to 24 hours in the future)
        if ($nextDate->lessThanOrEqualTo(today()->addDay())) {
            $this->batch()?->add([
                new ImportElectricityPricesPerDateJob($nextDate->format('Y-m-d')),
            ]);
        }
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            new SkipIfBatchCancelled,
        ];
    }
}

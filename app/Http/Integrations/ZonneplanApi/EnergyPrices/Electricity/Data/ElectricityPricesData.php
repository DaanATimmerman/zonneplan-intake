<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Data;

use Saloon\Http\Response;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ElectricityPricesData extends Data
{
    public function __construct(
        public int $startDate,
        public int $endDate,

        public string $period,

        public ?int $marketPrice,
        public ?int $totalPriceTaxIncluded,
        public ?int $priceInclHandlingVat,
        public ?int $priceTaxWithVat,

        public ?string $pricingProfile,
        public ?int $carbonFootprintInGram,
        public ?int $sustainabilityScore,

        public string $startDateDatetime,
    ) {}

    public static function format(Response $items): ElectricityPricesData
    {
        return ElectricityPricesData::from($items->array());
    }
}

<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Data;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Collections\ElectricityPricesDataCollection;
use Saloon\Http\Response;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\StudlyCaseMapper;

#[MapInputName(StudlyCaseMapper::class)]
class ElectricityPricesRequestData extends Data
{
    public function __construct(
        #[MapInputName('data')]
        public ?ElectricityPricesDataCollection $electricityPricesDataCollection,
    ) {}

    public static function format(Response $items): ElectricityPricesRequestData
    {
        return ElectricityPricesRequestData::from($items->array());
    }
}

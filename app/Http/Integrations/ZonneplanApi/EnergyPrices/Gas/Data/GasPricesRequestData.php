<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Data;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Collections\GasPricesDataCollection;
use Saloon\Http\Response;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\StudlyCaseMapper;

#[MapInputName(StudlyCaseMapper::class)]
class GasPricesRequestData extends Data
{
    public function __construct(
        #[MapInputName('data')]
        public ?GasPricesDataCollection $gasPricesDataCollection,
    ) {}

    public static function format(Response $items): GasPricesRequestData
    {
        return GasPricesRequestData::from($items->array());
    }
}

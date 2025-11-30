<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Collections;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Data\ElectricityPricesData;
use Illuminate\Support\Collection;

/**
 * @extends Collection<int, ElectricityPricesData>
 */
class ElectricityPricesDataCollection extends Collection
{
    public static string $dataClass = ElectricityPricesData::class;
}

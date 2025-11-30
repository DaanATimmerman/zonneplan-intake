<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Collections;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Data\GasPricesData;
use Illuminate\Support\Collection;

/**
 * @extends Collection<int, GasPricesData>
 */
class GasPricesDataCollection extends Collection
{
    public static string $dataClass = GasPricesData::class;
}

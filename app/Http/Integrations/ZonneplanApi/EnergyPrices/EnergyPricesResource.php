<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Data\ElectricityPricesRequestData;
use App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Requests\ElectricityPricesRequest;
use App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Data\GasPricesRequestData;
use App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Requests\GasPricesRequest;
use Saloon\Http\BaseResource;

class EnergyPricesResource extends BaseResource
{
    public function electricityPrices(?string $dateString = null): ElectricityPricesRequestData
    {
        return $this->connector->send(new ElectricityPricesRequest($dateString))->dto();
    }

    public function gasPrices(): GasPricesRequestData
    {
        return $this->connector->send(new GasPricesRequest)->dto();
    }
}

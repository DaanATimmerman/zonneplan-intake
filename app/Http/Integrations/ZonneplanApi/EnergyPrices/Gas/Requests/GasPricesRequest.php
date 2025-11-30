<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Requests;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Gas\Data\GasPricesRequestData;
use Saloon\Enums\Method;
use Saloon\Http\Response;
use Saloon\Http\SoloRequest;

class GasPricesRequest extends SoloRequest
{
    protected Method $method = Method::GET;

    public function __construct() {}

    public function resolveEndpoint(): string
    {
        return '/energy-prices/gas/upcoming';
    }

    public function createDtoFromResponse(Response $response): ?GasPricesRequestData
    {
        return GasPricesRequestData::format($response);
    }
}

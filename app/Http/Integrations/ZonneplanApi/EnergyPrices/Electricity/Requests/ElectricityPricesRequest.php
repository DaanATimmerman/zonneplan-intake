<?php

namespace App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Requests;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\Electricity\Data\ElectricityPricesRequestData;
use Saloon\Enums\Method;
use Saloon\Http\Response;
use Saloon\Http\SoloRequest;

class ElectricityPricesRequest extends SoloRequest
{
    protected Method $method = Method::GET;

    private ?string $dateString;

    public function __construct(?string $dateString = null)
    {
        $this->dateString = $dateString;
    }

    protected function defaultQuery(): array
    {
        if (! $this->dateString) {
            return [];
        }

        return [
            'date' => $this->dateString,
        ];
    }

    public function resolveEndpoint(): string
    {
        return '/energy-prices/electricity/upcoming';
    }

    public function createDtoFromResponse(Response $response): ?ElectricityPricesRequestData
    {
        return ElectricityPricesRequestData::format($response);
    }
}

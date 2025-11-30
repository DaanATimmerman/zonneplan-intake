<?php

namespace App\Http\Integrations\ZonneplanApi;

use App\Http\Integrations\ZonneplanApi\EnergyPrices\EnergyPricesResource;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class ZonneplanApi extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    public function __construct(
        public readonly string $key,
    ) {}

    public function resolveBaseUrl(): string
    {
        return config('services.zonneplan.base_api_url');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultQuery(): array
    {
        return [
            'secret' => $this->key,
        ];
    }

    protected function defaultConfig(): array
    {
        return [];
    }

    public function energyPrices(): EnergyPricesResource
    {
        return new EnergyPricesResource($this);
    }
}

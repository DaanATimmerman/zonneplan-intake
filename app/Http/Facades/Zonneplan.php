<?php

namespace App\Http\Facades;

use App\Http\Integrations\ZonneplanApi\ZonneplanApi;
use Illuminate\Support\Facades\Facade;

class Zonneplan extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ZonneplanApi::class;
    }
}

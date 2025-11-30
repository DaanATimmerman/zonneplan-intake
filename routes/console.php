<?php

use App\Console\Commands\GetCurrentElectricityPrice;
use App\Console\Commands\GetCurrentGasPrice;
use Illuminate\Support\Facades\Schedule;

Schedule::call(GetCurrentElectricityPrice::class)->everyFiveMinutes();
Schedule::call(GetCurrentGasPrice::class)->hourly();

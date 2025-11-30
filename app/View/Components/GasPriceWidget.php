<?php

namespace App\View\Components;

use App\Models\GasPrice;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GasPriceWidget extends Component
{
    public function render(): View|Closure|string
    {
        $fields = ['market_price', 'start_date', 'end_date'];

        $currentPrice = GasPrice::currentPrice()->select($fields)->first();

        return view('components.gas-price-widget', [
            'currentPrice' => $currentPrice,
        ]);
    }
}

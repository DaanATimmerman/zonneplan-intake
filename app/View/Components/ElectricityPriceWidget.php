<?php

namespace App\View\Components;

use App\Models\ElectricityPrice;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ElectricityPriceWidget extends Component
{
    public function render(): View|Closure|string
    {
        $fields = ['market_price', 'sustainability_score', 'start_date', 'end_date'];

        $currentPrice = ElectricityPrice::currentPrice()->select($fields)->first();
        $cheapestPrice = ElectricityPrice::cheapestUpcomingPrice()->select($fields)->first();
        $mostExpensivePrice = ElectricityPrice::mostExpensiveUpcomingPrice()->select($fields)->first();
        $mostSustainable = ElectricityPrice::mostSustainableUpcoming()->select($fields)->first();

        return view('components.electricity-price-widget', [
            'currentPrice' => $currentPrice,
            'cheapestPrice' => $cheapestPrice,
            'mostExpensivePrice' => $mostExpensivePrice,
            'mostSustainable' => $mostSustainable,
        ]);
    }
}

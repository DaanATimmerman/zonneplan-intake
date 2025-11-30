<?php

namespace Tests\Unit;

use App\Models\GasPrice;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GasPriceTest extends TestCase
{
    #[Test]
    public function it_scopes_future_and_now_prices()
    {
        $past = GasPrice::factory()->past()->create();
        $future = GasPrice::factory()->future()->create();

        $results = GasPrice::futureAndNow()->get();

        $this->assertTrue($results->contains($future));
        $this->assertFalse($results->contains($past));
    }

    #[Test]
    public function it_scopes_current_price()
    {
        $current = GasPrice::factory()->current()->create();

        $results = GasPrice::currentPrice()->get();

        $this->assertTrue($results->contains($current));
    }

    #[Test]
    public function it_scopes_cheapest_and_most_expensive_upcoming_prices()
    {
        $price1 = GasPrice::factory()->future()->create(['market_price' => 300]);
        $price2 = GasPrice::factory()->future()->create(['market_price' => 100]);

        $cheapest = GasPrice::cheapestUpcomingPrice()->first();
        $expensive = GasPrice::mostExpensiveUpcomingPrice()->first();

        $this->assertEquals($price2->id, $cheapest->id);
        $this->assertEquals($price1->id, $expensive->id);
    }

    #[Test]
    public function it_casts_market_price()
    {
        $rawValue = 123456789;
        $price = GasPrice::factory()->create(['market_price' => $rawValue]);

        $expected = (float) number_format($rawValue / 10000000, 8, '.', '');
        $this->assertEquals($expected, $price->market_price);
    }
}

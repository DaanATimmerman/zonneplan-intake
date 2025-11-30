<?php

namespace Tests\Unit;

use App\Models\ElectricityPrice;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ElectricityPriceTest extends TestCase
{
    #[Test]
    public function it_scopes_future_and_now_prices()
    {
        $past = ElectricityPrice::factory()->past()->create();
        $future = ElectricityPrice::factory()->future()->create();

        $results = ElectricityPrice::futureAndNow()->get();

        $this->assertTrue($results->contains($future));
        $this->assertFalse($results->contains($past));
    }

    #[Test]
    public function it_scopes_current_price()
    {
        $current = ElectricityPrice::factory()->current()->create();

        $results = ElectricityPrice::currentPrice()->get();

        $this->assertTrue($results->contains($current));
    }

    #[Test]
    public function it_scopes_cheapest_and_most_expensive_upcoming_prices()
    {
        $price1 = ElectricityPrice::factory()->future()->create(['market_price' => 300]);
        $price2 = ElectricityPrice::factory()->future()->create(['market_price' => 100]);

        $cheapest = ElectricityPrice::cheapestUpcomingPrice()->first();
        $expensive = ElectricityPrice::mostExpensiveUpcomingPrice()->first();

        $this->assertEquals($price2->id, $cheapest->id);
        $this->assertEquals($price1->id, $expensive->id);
    }

    #[Test]
    public function it_scopes_most_sustainable_upcoming_price()
    {
        $price1 = ElectricityPrice::factory()->future()->create(['sustainability_score' => 50]);
        $price2 = ElectricityPrice::factory()->future()->create(['sustainability_score' => 80]);

        $mostSustainable = ElectricityPrice::mostSustainableUpcoming()->first();

        $this->assertEquals($price2->id, $mostSustainable->id);
    }

    #[Test]
    public function it_casts_market_price()
    {
        $rawValue = 123456789;
        $price = ElectricityPrice::factory()->create(['market_price' => $rawValue]);

        $expected = (float) number_format($rawValue / 10000000, 8, '.', '');
        $this->assertEquals($expected, $price->market_price);
    }
}

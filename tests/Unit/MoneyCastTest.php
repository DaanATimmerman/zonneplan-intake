<?php

namespace Tests\Unit;

use App\Models\ElectricityPrice;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MoneyCastTest extends TestCase
{
    #[Test]
    public function it_correctly_casts_from_database_to_float()
    {
        $rawValue = fake()->numberBetween(1, 10000000);
        $expected = (float) number_format($rawValue / 10000000, 8, '.', '');

        $price = ElectricityPrice::create([
            'market_price' => $rawValue,
            'start_date' => now(),
            'end_date' => now()->addHour(),
        ]);

        $this->assertEquals($expected, $price->market_price);
    }

    #[Test]
    public function it_correctly_sets_value_to_database()
    {
        $valueToSet = fake()->numberBetween(1, 10000000);

        $price = ElectricityPrice::create([
            'market_price' => $valueToSet,
            'start_date' => now(),
            'end_date' => now()->addHour(),
        ]);

        $this->assertEquals($valueToSet, $price->getRawOriginal('market_price'));
    }

    #[Test]
    public function it_correctly_sets_null_to_database()
    {
        $valueToSet = null;

        $price = ElectricityPrice::create([
            'market_price' => $valueToSet,
            'start_date' => now(),
            'end_date' => now()->addHour(),
        ]);

        $this->assertEquals($valueToSet, $price->getRawOriginal('market_price'));
    }
}

<?php

namespace Database\Factories;

use App\Models\ElectricityPrice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectricityPriceFactory extends Factory
{
    protected $model = ElectricityPrice::class;

    public function definition()
    {
        $startHour = $this->faker->unique()->numberBetween(-5, 5);

        return [
            'market_price' => $this->faker->randomFloat(8, 0, 1000),
            'start_date' => Carbon::now()->addHours($startHour),
            'end_date' => Carbon::now()->addHours($this->faker->numberBetween(6, 10)),
            'sustainability_score' => $this->faker->numberBetween(0, 100),
        ];
    }

    // factory helpers
    public function future()
    {
        return $this->state(fn () => [
            'start_date' => Carbon::now()->addMinutes(rand(1, 60)), // within the next hour
            'end_date' => Carbon::now()->addHours(2)->addMinutes(rand(1, 60)),
        ]);
    }

    public function past()
    {
        return $this->state(fn () => [
            'start_date' => Carbon::now()->subHours(rand(2, 5)),
            'end_date' => Carbon::now()->subHours(rand(1, 2)),
        ]);
    }

    public function current()
    {
        return $this->state(fn () => [
            'start_date' => Carbon::now()->subMinutes(rand(1, 30)),
            'end_date' => Carbon::now()->addMinutes(rand(1, 30)),
        ]);
    }
}

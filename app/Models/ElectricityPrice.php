<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Database\Factories\ElectricityPriceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricityPrice extends Model
{
    /** @use HasFactory<ElectricityPriceFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'market_price' => MoneyCast::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * @param  Builder<ElectricityPrice>  $query
     * @return Builder<ElectricityPrice>
     */
    public function scopeFutureAndNow($query): Builder
    {
        return $query->where('start_date', '>=', now()->startOfHour());
    }

    /**
     * @param  Builder<ElectricityPrice>  $query
     * @return Builder<ElectricityPrice>
     */
    public function scopeCurrentPrice($query): Builder
    {
        $now = now();

        return $query->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /**
     * @param  Builder<ElectricityPrice>  $query
     * @return Builder<ElectricityPrice>
     */
    public function scopeCheapestUpcomingPrice($query): Builder
    {
        return $query->futureAndNow()
            ->whereNotNull('market_price')
            ->orderBy('market_price', 'asc')
            ->limit(1);
    }

    /**
     * @param  Builder<ElectricityPrice>  $query
     * @return Builder<ElectricityPrice>
     */
    public function scopeMostExpensiveUpcomingPrice($query): Builder
    {
        return $query->futureAndNow()
            ->whereNotNull('market_price')
            ->orderBy('market_price', 'desc')
            ->limit(1);
    }

    /**
     * @param  Builder<ElectricityPrice>  $query
     * @return Builder<ElectricityPrice>
     */
    public function scopeMostSustainableUpcoming($query): Builder
    {
        return $query->futureAndNow()
            ->orderBy('sustainability_score', 'desc')
            ->limit(1);
    }
}

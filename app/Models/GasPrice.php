<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Database\Factories\GasPriceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasPrice extends Model
{
    /** @use HasFactory<GasPriceFactory> */
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
     * @param  Builder<GasPrice>  $query
     * @return Builder<GasPrice>
     */
    public function scopeFutureAndNow($query): Builder
    {
        return $query->where('start_date', '>=', now()->startOfHour());
    }

    /**
     * @param  Builder<GasPrice>  $query
     * @return Builder<GasPrice>
     */
    public function scopeCurrentPrice($query): Builder
    {
        $now = now();

        return $query->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /**
     * @param  Builder<GasPrice>  $query
     * @return Builder<GasPrice>
     */
    public function scopeCheapestUpcomingPrice($query): Builder
    {
        return $query->futureAndNow()
            ->whereNotNull('market_price')
            ->orderBy('market_price', 'asc')
            ->limit(1);
    }

    /**
     * @param  Builder<GasPrice>  $query
     * @return Builder<GasPrice>
     */
    public function scopeMostExpensiveUpcomingPrice($query): Builder
    {
        return $query->futureAndNow()
            ->whereNotNull('market_price')
            ->orderBy('market_price', 'desc')
            ->limit(1);
    }
}

<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<float, int>
 */
class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?float
    {
        if (! $value) {
            return null;
        }

        return (float) number_format(($value / 10000000), 8, '.', '');
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return $value;
    }
}

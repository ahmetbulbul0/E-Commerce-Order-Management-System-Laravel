<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CommonQueryScopes
{
    public function scopeFilterByPrice(Builder $query, ?float $min = null, ?float $max = null): Builder
    {
        if (!is_null($min)) {
            $query->where('price', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function scopeSearchByName(Builder $query, ?string $term): Builder
    {
        if ($term) {
            $query->where('name', 'like', "%{$term}%");
        }
        return $query;
    }
}



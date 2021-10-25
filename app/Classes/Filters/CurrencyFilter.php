<?php

namespace App\Classes\Filters;

use App\Classes\Filters\FilterAbstract;
use App\Constants\Plan\PlanId;
use Illuminate\Database\Eloquent\Builder;

class CurrencyFilter extends FilterAbstract
{

    /**
     * Filter by course difficulty.
     *
     * @param  string $access
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        if ($value === null) {
            return $builder;
        }

        return $builder->whereHas( 'activeSubscription', function ( $activeSubscription ) use( $value ) {
            $activeSubscription->where('currency', $value );
        } );
    }
}

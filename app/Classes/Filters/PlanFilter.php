<?php

namespace App\Classes\Filters;

use App\Classes\Filters\FilterAbstract;
use App\Constants\Plan\PlanId;
use Illuminate\Database\Eloquent\Builder;

class PlanFilter extends FilterAbstract
{
    /**
     * Mappings for database values.
     *
     * @return array
     */
    public function mappings()
    {
        return [
            'pro'   => PlanId::PRO,
            'turbo' => PlanId::TURBO,
        ];
    }

    /**
     * Filter by course difficulty.
     *
     * @param  string $access
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }

        return $builder->whereHas( 'activeSubscription', function ( $activeSubscription ) use( $value ) {
            $activeSubscription->where('plan_id', $value );
        } );
    }
}

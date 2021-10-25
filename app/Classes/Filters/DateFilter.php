<?php

namespace App\Classes\Filters;

use App\Classes\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class DateFilter extends FilterAbstract
{
    /**
     * Filter by course difficulty.
     *
     * @param  string $access
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveDateValue($value);

        if ( $value === null ) {
            return $builder;
        }

        return $builder->whereHas( 'activeSubscription', function ( $activeSubscription ) use( $value ) {
            $activeSubscription->whereDay('created_at', $value->day )
                                ->whereMonth( 'created_at', $value->month )
                                ->whereYear( 'created_at', $value->year );
        } );
    }
}

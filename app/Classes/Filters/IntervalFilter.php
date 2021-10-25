<?php

namespace App\Classes\Filters;

use App\Classes\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class IntervalFilter extends FilterAbstract
{
    /**
     * Filter by course difficulty.
     *
     * @param  string $access
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter( Builder $builder, $value )
    {
        $arrayOfTimeInterval = explode( 'to', $value );

        if ($value === null || count( $arrayOfTimeInterval ) != 2 ) {
            return $builder;
        }

        $fromDate = $this->resolveDateValue( $arrayOfTimeInterval[0] );

        $toDate = $this->resolveDateValue( $arrayOfTimeInterval[1] );

        return $builder->whereHas( 'activeSubscription', function ( $activeSubscription ) use( $fromDate, $toDate ) {
            $activeSubscription->whereBetween('created_at', [ $fromDate, $toDate ] );
        } );
    }
}

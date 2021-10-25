<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Constants\Readables\Subscription\SubscriptionReadableTrait;

class Subscription extends Model
{
    use SubscriptionReadableTrait;
    
    /**
     * scopeActive
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive( Builder $query )
    {
        return $query->where( 'is_active', true )
                    ->whereNotNull( 'user_id' );
    }

    /**
     * scopeFirstTime
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFirstTime( Builder $query )
    {
        return $query->distinct( 'user_id' );
    }
}

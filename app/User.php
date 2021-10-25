<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Classes\Filters\User\UserFilters;
use Illuminate\Database\Eloquent\Builder;
use App\Constants\Transaction\TransactionStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * $appends
     *
     * @var array
     */
    protected $appends = [ 'subscription_id', 'plan_id', 'subscription_created_at', 'selar_profit' ];

    /**
     * getSubscriptionIdAttribute
     *
     * @return void
     */
    public function getSubscriptionIdAttribute()
    {
        return $this->activeSubscription->id;
    }

    /**
     * getSubscriptionCreatedAtAttribute
     *
     * @return void
     */
    public function getSubscriptionCreatedAtAttribute()
    {
        return $this->activeSubscription->created_at;
    }

    /**
     * getPlanIdAttribute
     *
     * @return void
     */
    public function getPlanIdAttribute()
    {
        return $this->activeSubscription->plan_id;
    }

    /**
     * getSelarProfitAttribute
     *
     * @return void
     */
    public function getSelarProfitAttribute()
    {
        return $this->paidTransactions->sum( 'selar_profit' );
    }

    /**
     * subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions ()
    {
        return $this->hasMany( Subscription::class );
    }

    /**
     * subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription ()
    {
        return $this->hasOne( Subscription::class );
    }

    /**
     * activeSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activeSubscription ()
    {
        return $this->hasOne( Subscription::class )
                    ->where( 'is_active', true );
    }

    /**
     * paidTransactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paidTransactions ()
    {
        return $this->hasMany( Transaction::class )
                    ->where( 'status', TransactionStatus::PAID );
    }

    /**
     * scopeSubscribers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSubscribers( Builder $query )
    {
        return $query->has( 'subscriptions');
    }

    /**
     * scopeActiveSubscribers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActiveSubscribers( Builder $query )
    {
        return $query->whereHas( 'subscriptions', function ( $subscription ) {
            $subscription->where( 'is_active', true );
        } );
    }

    /**
     * scopeDateFilteredActiveSubscribers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDateFilteredActiveSubscribers( Builder $query )
    {
        return $query->activeSubscribers()->whereHas( 'subscriptions', function ( $subscription ) {
            $subscription->whereYear( 'created_at', request( 'allSubscribersYear', now()->year ) );
        } );
    }

    /**
     * scopeFirstTimeSubscribers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFirstTimeSubscribers( Builder $query )
    {
        return $query->activeSubscribers()->whereDoesntHave( 'subscription', function ( $subscription ) {
            $subscription->whereYear( 'created_at', '<', request( 'firstTimeSubscribersYear', now()->year ) );
        })->whereHas( 'subscription', function ( $subscription ) {
            $subscription->whereYear( 'created_at', request( 'firstTimeSubscribersYear', now()->year ) );
        } );
    }

    /**
     * scopeReturningSubscribers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeReturningSubscribers( Builder $query )
    {
        return $query->activeSubscribers()->whereHas( 'subscription', function ( $subscription ) {
            $subscription->whereYear( 'created_at', '<', request( 'returningSubscribersYear', now()->year ) );
        })->whereHas( 'subscription', function ( $subscription ) {
            $subscription->whereYear( 'created_at', request( 'returningSubscribersYear', now()->year ) );
        } );
    }

    /**
     * scopeUnsubscribers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnsubscribers( Builder $query )
    {
        return $query->doesntHave( 'subscriptions' );
    }

    /**
     * scopeFilter
     *
     * @param Builder $builder
     * @param Request $request
     * @param array $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return ( new UserFilters( request() ) )->add( $filters )->filter( $builder );
    }
}

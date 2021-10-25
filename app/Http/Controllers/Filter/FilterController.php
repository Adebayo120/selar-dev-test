<?php

namespace App\Http\Controllers\Filter;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterController extends Controller {

    /**
     * action
     *
     * @param string $filterType
     * @return void
     */
    public function action( Request $request, string $filterType )
    {
        $models = $this->{"{$filterType}SubscribersFilter" } ( $request );

        return view( "includes.filterables.tables.{$request->pagename}")
                    ->with( [ 
                        'subscribers'   => $models,
                        'identifier'    => $filterType
                    ] )
                    ->render();
    }

    /**
     * allSubscribersFilter
     *
     * @param Request $request
     * @return void
     */
    public function allSubscribersFilter ( Request $request )
    {
        return User::dateFilteredActiveSubscribers()->filter( $request )->with( 'subscriptions', 'activeSubscription' )->get();
    }

    /**
     * firstTimeSubscribersFilter
     *
     * @param Request $request
     * @return void
     */
    public function firstTimeSubscribersFilter ( Request $request )
    {
        return User::firstTimeSubscribers()->filter( $request )->with( 'activeSubscription' )->get();
    }

    /**
     * returningSubscribersFilter
     *
     * @return void
     */
    public function returningSubscribersFilter ( Request $request )
    {
        return User::returningSubscribers()->filter( $request )->with( 'activeSubscription' )->get();
    }
}
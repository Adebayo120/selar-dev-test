<?php

namespace App\Http\Controllers\Subscriber;

use App\User;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\Constants\Plan\PlanId;
use App\Http\Controllers\Controller;
use App\Constants\Transaction\TransactionCurrency;
use App\Subscription;

class SubscriberController extends Controller
{
    /**
     * index
     *
     * @param Request $request
     * @return void
     */
    public function index ( Request $request )
    {
        $allSubscribers = User::dateFilteredActiveSubscribers()->with( 'activeSubscription' )->get();

        $firstTimeSubscribers = User::firstTimeSubscribers()->with( [ 'subscriptions', 'activeSubscription' ])->get();

        $returningSubscribers = User::returningSubscribers()->with( 'activeSubscription' )->get();

        $chartResources = [];

        list( $chartResources, $allSubscribersCount, $totalAllSubscribersOnProPlan, $totalAllSubscribersOnTurboPlan, $allSubscribersTotalUsdProfit, $allSubscribersTotalNairaProfit ) = $this->updateChartResourcesAndGetTotals( $chartResources, $allSubscribers, 'all' );

        list( $chartResources, $firstTimeSubscribersCount, $totalfirstTimeSubscribersOnProPlan, $totalfirstTimeSubscribersOnTurboPlan, $firstTimeSubscribersTotalUsdProfit, $firstTimeSubscribersTotalNairaProfit ) = $this->updateChartResourcesAndGetTotals( $chartResources, $firstTimeSubscribers, 'firstTime' );

        list( $chartResources, $returningSubscribersCount, $totalreturningSubscribersOnProPlan, $totalreturningSubscribersOnTurboPlan, $returningSubscribersTotalUsdProfit, $returningSubscribersTotalNairaProfit ) = $this->updateChartResourcesAndGetTotals( $chartResources, $returningSubscribers, 'returning' );

        $firstSubscriptionYear = Subscription::first()->created_at->year;

        $arrayOfSubscribersYears = range( now()->year, $firstSubscriptionYear );

        return view('subscribers.index')->with( [
            'chartResources'                        => $chartResources,
            'allSubscribers'                        => $allSubscribers,
            'allSubscribersCount'                   => $allSubscribersCount,
            'totalAllSubscribersOnProPlan'          => $totalAllSubscribersOnProPlan,
            'totalAllSubscribersOnTurboPlan'        => $totalAllSubscribersOnTurboPlan,
            'allSubscribersTotalUsdProfit'          => $allSubscribersTotalUsdProfit,
            'allSubscribersTotalNairaProfit'        => $allSubscribersTotalNairaProfit,
            'firstTimeSubscribers'                  => $firstTimeSubscribers,
            'firstTimeSubscribersCount'             => $firstTimeSubscribersCount,
            'totalfirstTimeSubscribersOnProPlan'    => $totalfirstTimeSubscribersOnProPlan,
            'totalfirstTimeSubscribersOnTurboPlan'  => $totalfirstTimeSubscribersOnTurboPlan,
            'firstTimeSubscribersTotalUsdProfit'    => $firstTimeSubscribersTotalUsdProfit,
            'firstTimeSubscribersTotalNairaProfit'  => $firstTimeSubscribersTotalNairaProfit,
            'returningSubscribers'                  => $returningSubscribers,
            'returningSubscribersCount'             => $returningSubscribersCount,
            'totalreturningSubscribersOnProPlan'    => $totalreturningSubscribersOnProPlan,
            'totalreturningSubscribersOnTurboPlan'  => $totalreturningSubscribersOnTurboPlan,
            'returningSubscribersTotalUsdProfit'    => $returningSubscribersTotalUsdProfit,
            'returningSubscribersTotalNairaProfit'  => $returningSubscribersTotalNairaProfit,
            'arrayOfSubscribersYears'               => $arrayOfSubscribersYears
        ] );
    }

    /**
     * updateChartResourcesAndGetTotals
     *
     * @param array $chartResources
     * @param [type] $subscribers
     * @param [type] $identifier
     * @return array
     */
    public function updateChartResourcesAndGetTotals ( array $chartResources, $subscribers, $identifier )
    {
        $proPlanSubscribers = $subscribers->where( 'plan_id', PlanId::PRO );

        $turboPlanSubscribers = $subscribers->where( 'plan_id', PlanId::TURBO );

        $subscriberIds = $subscribers->pluck( "id" )->toArray();

        $subscribersPaidTransactions = Transaction::paid()->whereIn( 'user_id', $subscriberIds )->get();

        $usdPaidTransactions = $subscribersPaidTransactions->where( 'currency', TransactionCurrency::USD );

        $nairaPaidTransactions = $subscribersPaidTransactions->where( 'currency', TransactionCurrency::NAIRA );

        $arrayOfMonths = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $arrayOfSubscribersCountGoupedInMonths = $this->getSubscribersCountGoupedInMonths( $subscribers );

        $arrayOfProPlanSubscribersCountGoupedInMonths = $this->getSubscribersCountGoupedInMonths( $proPlanSubscribers );

        $arrayOfTurboPlanSubscribersCountGoupedInMonths = $this->getSubscribersCountGoupedInMonths( $turboPlanSubscribers );

        $arrayOfUsdPaidTransactionsGoupedInMonths = $this->getSubscribersCountGoupedInMonths( $usdPaidTransactions, true );

        $arrayOfNairaPaidTransactionsGoupedInMonths = $this->getSubscribersCountGoupedInMonths( $nairaPaidTransactions, true );

        $totalSubscribers = $subscribers->count();

        $totalProPlanSubscribers = $proPlanSubscribers->count();

        $totalTurboPlanSubscribers = $turboPlanSubscribers->count();

        $totalUsdProfit = $usdPaidTransactions->sum( 'selar_profit' );

        $totalNairaProfit = $nairaPaidTransactions->sum( 'selar_profit' );

        $chartResources[ "{$identifier}Subscribers" ] = [
            'label' => $arrayOfMonths,
            'data'  => $arrayOfSubscribersCountGoupedInMonths
        ];

        $chartResources[ "{$identifier}ProPlanSubscribers" ] = [
            'label' => $arrayOfMonths,
            'data'  => $arrayOfProPlanSubscribersCountGoupedInMonths
        ];

        $chartResources[ "{$identifier}TurboPlanSubscribers" ] = [
            'label' => $arrayOfMonths,
            'data'  => $arrayOfTurboPlanSubscribersCountGoupedInMonths
        ];

        $chartResources[ "{$identifier}UsdProfits" ] = [
            'label' => $arrayOfMonths,
            'data'  => $arrayOfUsdPaidTransactionsGoupedInMonths
        ];

        $chartResources[ "{$identifier}NairaProfits" ] = [
            'label' => $arrayOfMonths,
            'data'  => $arrayOfNairaPaidTransactionsGoupedInMonths
        ];

        return [
            $chartResources,
            $totalSubscribers,
            $totalProPlanSubscribers,
            $totalTurboPlanSubscribers,
            $totalUsdProfit,
            $totalNairaProfit
        ];
    }

    /**
     * getSubscribersCountGoupedInMonths
     *
     * @param [type] $type
     * @return array
     */
    public function getSubscribersCountGoupedInMonths ( $subscribers, $profit = false )
    {
        $subsribersGroupedInMonths = $subscribers->groupBy( function ( $subscriber ) {
                                                        return (int)Carbon::parse( $subscriber->created_at )->format("m");
                                                    } );
                                                        
        $arrayOfSubsribersCountGroupedInMonths = [];

        for ( $i = 1; $i <= 12; $i++ )
        {
            if ( isset( $subsribersGroupedInMonths[ $i ] ) )
            {
                $arrayOfSubsribersCountGroupedInMonths[] = $profit ? $subsribersGroupedInMonths[ $i ]->sum( 'selar_profit' ) : count ( $subsribersGroupedInMonths[ $i ] );
            }
            else
            {
                $arrayOfSubsribersCountGroupedInMonths[] = 0;
            }
        }

        return $arrayOfSubsribersCountGroupedInMonths;
    }
}

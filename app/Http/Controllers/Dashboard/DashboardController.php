<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Transaction;
use App\Constants\Plan\PlanId;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Constants\Transaction\TransactionCurrency;
use App\Subscription;

class DashboardController extends Controller
{
    
    /**
     * index
     *
     * @return void
     */
    public function index ()
    {
        $subscribers = Subscription::active()->get();

        $proPlanSubscribers = $subscribers->where( 'plan_id', PlanId::PRO );

        $turboPlanSubscribers = $subscribers->where( 'plan_id', PlanId::TURBO );

        $paidTransactions = Transaction::paid()->get();

        $usdPaidTransactions = $paidTransactions->where( 'currency', TransactionCurrency::USD );

        $nairaPaidTransactions = $paidTransactions->where( 'currency', TransactionCurrency::NAIRA );

        list( $arrayOfGroupedSubscribersCount, $arrayOfGroupedSubscribersYears ) = $this->getModelsGroupCountAndListOfYears( $subscribers );

        list( $arrayOfGroupedProPlanSubscribersCount, $arrayOfGroupedProPlanSubscribersYears ) = $this->getModelsGroupCountAndListOfYears( $proPlanSubscribers );

        list( $arrayOfGroupedTurboPlanSubscribersCount, $arrayOfGroupedTurboPlanSubscribersYears ) = $this->getModelsGroupCountAndListOfYears( $turboPlanSubscribers );

        list( $arrayOfGroupedUsdProfits, $arrayOfGroupedUsdProfitsYears ) = $this->getModelsGroupCountAndListOfYears( $usdPaidTransactions, true );

        list( $arrayOfGroupedNairaProfits, $arrayOfGroupedNairaProfitsYears ) = $this->getModelsGroupCountAndListOfYears( $nairaPaidTransactions, true );

        $totalSubscribers = $subscribers->count();

        $totalProPlanSubscribers = $proPlanSubscribers->count();

        $totalTurboPlanSubscribers = $turboPlanSubscribers->count();

        $totalUsdProfit = $usdPaidTransactions->sum( 'selar_profit' );

        $totalNairaProfit = $nairaPaidTransactions->sum( 'selar_profit' );

        $chartResources = [
            'allSubscribers' => [
                'lable' => $arrayOfGroupedSubscribersYears,
                'data'  => $arrayOfGroupedSubscribersCount
            ],
            'allProPlanSubscribers' => [
                'lable' => $arrayOfGroupedProPlanSubscribersYears,
                'data'  => $arrayOfGroupedProPlanSubscribersCount
            ],
            'allTurboPlanSubscribers' => [
                'lable' => $arrayOfGroupedTurboPlanSubscribersYears,
                'data'  => $arrayOfGroupedTurboPlanSubscribersCount
            ],
            'allUsdProfits' => [
                'lable' => $arrayOfGroupedUsdProfitsYears,
                'data'  => $arrayOfGroupedUsdProfits
            ],
            'allNairaProfits' => [
                'lable' => $arrayOfGroupedNairaProfitsYears,
                'data'  => $arrayOfGroupedNairaProfits
            ],
        ];

        return view('dashboard.dashboard')->with( [
            'totalSubscribers'          => $totalSubscribers,
            'totalProPlanSubscribers'   => $totalProPlanSubscribers,
            'totalTurboPlanSubscribers' => $totalTurboPlanSubscribers,
            'totalUsdProfit'            => $totalUsdProfit,
            'totalNairaProfit'          => $totalNairaProfit,
            'chartResources'            => $chartResources
        ] );
    }

    /**
     * getModelsGroupCountAndListOfYears
     *
     * @param Collection $models
     * @param boolean $profit
     * @return array
     */
    public function getModelsGroupCountAndListOfYears ( Collection $models, $profit = false )
    {
        $modelsGroupedInyears = $models->groupBy( function ( $model ) {
            return Carbon::parse( $model->created_at )->year;
        });

        $arrayOfGroupedModelsYears = [];

        $arrayOfGroupedModelsCount = [];

        foreach ($modelsGroupedInyears as $year => $models ) 
        {
            $arrayOfGroupedModelsYears[] = $year;

            $arrayOfGroupedModelsCount[] = $profit ? $models->sum( 'selar_profit' ) : $models->count();
        }

        return [ $arrayOfGroupedModelsCount, $arrayOfGroupedModelsYears ];
    }
}

@extends('layouts.app')

@section('title', 'Selar Dev Test - Subscribers')

@section('heading', 'Subscribers')

@section('content')
  <div class="container-fluid">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item mr-5" role="presentation">
            <button class="nav-link active" id="all-subscribers-tab" data-toggle="tab" data-target="#all-subscribers" type="button" role="tab" aria-controls="all-subscribers" aria-selected="true">All Subscribers</button>
          </li>
          <li class="nav-item mr-5" role="presentation">
            <button class="nav-link" id="first-time-subscribers-tab" data-toggle="tab" data-target="#first-time-subscribers" type="button" role="tab" aria-controls="first-time-subscribers" aria-selected="false">First Time Subscribers</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="returning-subscribers-tab" data-toggle="tab" data-target="#returning-subscribers" type="button" role="tab" aria-controls="returning-subscribers" aria-selected="false">Returning Subscribers</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active pt-4" id="all-subscribers" role="tabpanel" aria-labelledby="all-subscribers-tab">
            @include('includes.subscribers.index', [
              'subscribers'               => $allSubscribers,
              'totalSubscribers'          => $allSubscribersCount,
              'totalProPlanSubscribers'   => $totalAllSubscribersOnProPlan,
              'totalTurboPlanSubscribers' => $totalAllSubscribersOnTurboPlan,
              'identifier'                => 'all',
            ])
          </div>
          <div class="tab-pane fade pt-4" id="first-time-subscribers" role="tabpanel" aria-labelledby="first-time-subscribers-tab">
            @include('includes.subscribers.index', [
              'subscribers'               => $firstTimeSubscribers,
              'totalSubscribers'          => $firstTimeSubscribersCount,
              'totalProPlanSubscribers'   => $totalfirstTimeSubscribersOnProPlan,
              'totalTurboPlanSubscribers' => $totalfirstTimeSubscribersOnTurboPlan,
              'identifier'                => 'firstTime',
            ])
          </div>
          <div class="tab-pane fade pt-4" id="returning-subscribers" role="tabpanel" aria-labelledby="returning-subscribers-tab">
            @include('includes.subscribers.index', [
              'subscribers'               => $returningSubscribers,
              'totalSubscribers'          => $returningSubscribersCount,
              'totalProPlanSubscribers'   => $totalreturningSubscribersOnProPlan,
              'totalTurboPlanSubscribers' => $totalreturningSubscribersOnTurboPlan,
              'identifier'                => 'returning',
            ])
          </div>
        </div>
  </div>
@endsection

@section('scripts')
    @parent
    <script>
      const chartsResources = JSON.parse('{!! json_encode($chartResources) !!}');
      $( '#allUsdTotalProfit' ).text( currencyFormatter( `{{ $allSubscribersTotalUsdProfit }}`, 'USD' ) );
      $( '#allNairaTotalProfit' ).text( currencyFormatter( `{{ $allSubscribersTotalNairaProfit }}`, 'NGN' ) );
      $( '#firstTimeUsdTotalProfit' ).text( currencyFormatter( `{{ $firstTimeSubscribersTotalUsdProfit }}`, 'USD' ) );
      $( '#firstTimeNairaTotalProfit' ).text( currencyFormatter( `{{ $firstTimeSubscribersTotalNairaProfit }}`, 'NGN' ) );
      $( '#returningUsdTotalProfit' ).text( currencyFormatter( `{{ $returningSubscribersTotalUsdProfit }}`, 'USD' ) );
      $( '#returningNairaTotalProfit' ).text( currencyFormatter( `{{ $returningSubscribersTotalNairaProfit }}`, 'NGN' ) );
  </script>
  <script src="{{ asset( 'js/demo/chart-area-demo.js' ) }}"></script>
  @include('includes.filterables.js')
@endsection
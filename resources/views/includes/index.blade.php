<div class="d-flex justify-content-between mb-4">
    <div class="w-20 mr-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Usd Profit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="{{ $identifier }}UsdTotalProfit">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-20 mr-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Naira Profit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="{{ $identifier }}NairaTotalProfit">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-20 mr-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Subscribers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSubscribers }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-20 mr-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pro Plan Subscribers
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalProPlanSubscribers }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-20 mr-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Turbo Plan Subscribers
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalTurboPlanSubscribers }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ( request()->is('subscribers') )
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle {{ $identifier }}SubscribersYear" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ request("{$identifier}SubscribersYear", now()->year ) }}
            </button>
            <div class="dropdown-menu">
                @foreach ( $arrayOfSubscribersYears as $year )
                    <a class="dropdown-item filterByYear" data-index="{{ $identifier }}SubscribersYear" href="#">{{ $year }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Usd Profits</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas class="profitChart" data-currency="USD" data-header="Usd Profit" data-id="{{ $identifier }}UsdProfits"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Naira Profits</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas class="profitChart" data-currency="NGN" data-header="Naira Profit" data-id="{{ $identifier }}NairaProfits"></canvas>
                </div>
            </div>
        </div>
    </div>
    @if ( request()->is('/') )
        <div class="col-xl-6 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Subscribers</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas class="subscriberChart" data-header="Subscriber" data-id="{{ $identifier }}Subscribers"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pro Plan Subscribers</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas class="subscriberChart" data-header="Pro Plan Subscriber" data-id="{{ $identifier }}ProPlanSubscribers"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Turbo Plan Subscribers</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas class="subscriberChart" data-header="Turbo Plan Subscriber" data-id="{{ $identifier }}TurboPlanSubscribers"></canvas>
                    </div>
                </div>
            </div>
        </div>  
    @endif
</div>
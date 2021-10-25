@extends('layouts.app')

@section('title', 'Selar Dev Test - Dashboard')

@section('heading', 'Dashboard')

@section('content')
    <div class="container-fluid">
        @include('includes.index', [
            'identifier'    => 'all'
        ])
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        const chartsResources = JSON.parse('{!! json_encode($chartResources) !!}');
        $( '#allUsdTotalProfit' ).text( currencyFormatter( `{{ $totalUsdProfit }}`, 'USD' ) );
        $( '#allNairaTotalProfit' ).text( currencyFormatter( `{{ $totalNairaProfit }}`, 'NGN' ) );
    </script>
    <script src="{{ asset( 'js/demo/chart-area-demo.js' ) }}"></script>
@endsection
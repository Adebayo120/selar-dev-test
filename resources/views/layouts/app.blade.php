<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset( 'css/sb-admin-2.min.css' ) }}" rel="stylesheet">
    <link href="{{ asset( 'css/selar-dev-test.css' ) }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script>
        function currencyFormatter( currencyValue, currencyUnit ) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currencyUnit,
                minimumFractionDigits: 2
            })
            return formatter.format( currencyValue )
        }
    </script>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route( 'dashboard' ) }}">
                <div class="sidebar-brand-text mx-3">Selar Dev Test</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ request()->is( '/' ) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route( 'dashboard' ) }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item {{ request()->is( 'subscribers' ) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route( 'subscribers' ) }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Subscribers</span>
                </a>
            </li>
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0 text-gray-800">@yield('heading')</h1>
                </nav>
                @yield('content')
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="{{ asset( 'vendor/jquery/jquery.min.js' ) }}"></script>
    <script src="{{ asset( 'vendor/bootstrap/js/bootstrap.bundle.min.js' ) }}"></script>
    <script src="{{ asset( 'vendor/jquery-easing/jquery.easing.min.js' ) }}"></script>
    <script src="{{ asset( 'js/sb-admin-2.min.js' ) }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $( document ).on( 'change', '.switch-checkbox', function () {
            let slider = $( this ).next();
            if ( $(this).prop("checked") ) {
                slider.removeClass('unchecked');
                slider.text( 'NGN' );
            } else {
                slider.addClass('unchecked');
                slider.text( 'USD' );
            }
        } )
        $(".datepicker").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
        $(".datepicker.interval").flatpickr({
            mode: "range",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    </script>
    @yield('scripts')
</body>

</html>
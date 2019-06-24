<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{env('STORE_NAME')}} | build : {{env('APP_BUILD')}} version : {{env('APP_VERSION')}}  </title>
    <!-- Favicon-->
    {{-- <link rel="icon" href="favicon.ico" type="image/x-icon"> --}}

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('admin/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('admin/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('admin/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('admin/plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('admin/css/themes/all-themes.css') }}" rel="stylesheet" />

    @yield('styles')
</head>
<body class="{{ Request::is('admin/login') ? '' : 'theme-red' }}">
    @include('admin.partials.loader')
    @if(Request::is('admin/login'))
        @yield('content')
    @else

        <!-- Top Bar -->
        @include('admin.partials.nav')
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    @include('admin.partials.userinfo')
                </div>
                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    @include('admin.partials.menu')
                </div>
                <!-- #Menu -->

                <div class="legal">
                    <div class="version">
                        <b>build : </b>{{env('APP_BUILD')}} | <b>version : </b> {{env('APP_VERSION')}}
                    </div>
                </div>

            </aside>
            <!-- #END# Left Sidebar -->
            <!-- Right Sidebar -->
            @include('admin.partials.aside')
            <!-- #END# Right Sidebar -->
        </section>

        <section class="content">
            @yield('content')
        </section>
    @endif

    <!-- Jquery Core Js -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('admin/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('admin/plugins/node-waves/waves.js') }}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset('admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/morrisjs/morris.js') }}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('admin/plugins/chartjs/Chart.bundle.js') }}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('admin/js/admin.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('admin/js/demo.js') }}"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{ asset('admin/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
            if (colorName === null || colorName === '') { colorName = 'bg-black'; }
            if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
            if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
            if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
            var allowDismiss = true;

            $.notify({
                message: text
            },
            {
                type: colorName,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                timer: 1000,
                placement: {
                    from: placementFrom,
                    align: placementAlign
                },
                animate: {
                    enter: animateEnter,
                    exit: animateExit
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">—</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
                });
            }
    </script>

    @if($errors->any())
        <script>
            $(function(){
                @foreach($errors->all() as $error)
                    showNotification('alert-danger', '{{ $error }}', 'top', 'right', '', '');
                @endforeach
            });
        </script>
    @endif

    @if(session('status'))
        <script>
            $(function(){
                showNotification('alert-success', '{{ session('status') }}', 'top', 'right', '', '');
            });
        </script>
    @endif

    @yield('scripts')
</body>

</html>

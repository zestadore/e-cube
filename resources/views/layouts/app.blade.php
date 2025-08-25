<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/core/libs.min.css') }}" />
    
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/hope-ui.min.css') }}?v=2.0.0" />
    
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom.min.css') }}?v=2.0.0" />
    
    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/dark.min.css') }}"/>
    
    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/customizer.min.css') }}" />
    
    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/rtl.min.css') }}"/>

    <!-- Scripts -->
    
</head>
<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    
    </div>
    <!-- loader END -->
    
    <div class="wrapper">
        @auth
            @include('layouts.side_menu')
        @endauth
        <main class="main-content">
            @auth
                @include('layouts.top_menu')
            @endauth
            @yield('content')
        </main>
    </div>
    <!-- Library Bundle Script -->
    <script src="{{ asset('admin_assets/js/core/libs.min.js') }}"></script>
    
    <!-- External Library Bundle Script -->
    <script src="{{ asset('admin_assets/js/core/external.min.js') }}"></script>
    
    <!-- Widgetchart Script -->
    <script src="{{ asset('admin_assets/js/charts/widgetcharts.js') }}"></script>
    
    <!-- mapchart Script -->
    <script src="{{ asset('admin_assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('admin_assets/js/charts/dashboard.js') }}" ></script>
    
    <!-- fslightbox Script -->
    <script src="{{ asset('admin_assets/js/plugins/fslightbox.js') }}"></script>
    
    <!-- Settings Script -->
    <script src="{{ asset('admin_assets/js/plugins/setting.js') }}"></script>
    
    <!-- Slider-tab Script -->
    <script src="{{ asset('admin_assets/js/plugins/slider-tabs.js') }}"></script>
    
    <!-- Form Wizard Script -->
    <script src="{{ asset('admin_assets/js/plugins/form-wizard.js') }}"></script>
    
    <!-- AOS Animation Plugin-->
    
    <!-- App Script -->
    <script src="{{ asset('admin_assets/js/hope-ui.js') }}" defer></script>
    @yield('scripts')
</body>
</html>

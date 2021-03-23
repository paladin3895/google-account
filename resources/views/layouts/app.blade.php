<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app"
        user="{{ json_encode(\Auth::user(), JSON_FORCE_OBJECT) }}"
        routes="{{ json_encode($h->getRoutes(), JSON_FORCE_OBJECT) }}"
        config="{{ json_encode([], JSON_FORCE_OBJECT) }}"
        class="">
        <navbar-component
            ></navbar-component>
        <div class="container">
            <div class="row mt-3">
                <div class="col">
                    <auth-component></auth-component>
                    <dashboard-component></dashboard-component>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

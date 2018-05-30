<head>

  <title>@yield('title', config('app.name'))</title>
  <meta name="description" content="@yield('description', config('app.description'))"/>
  <meta name="keywords" content="@yield('keywords', config('app.keywords'))"/>
  <meta name="copyright" content="{{ config('app.name') }}">
  <meta name="author" content="{{ config('app.name') }}"/>
  <meta name="application-name" content="@yield('title', config('app.name'))">
  <!--GEO Tags-->
  <meta name="DC.title" content="@yield('title', config('app.name'))"/>
  <meta name="geo.region" content="SA-RUH"/>
  <meta name="geo.placename" content="Riyadh"/>

  <!--Facebook Tags-->
  <meta property="og:site_name" content="{{ config('app.name') }}">
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="{{ request()->fullUrl() }}"/>
  <meta property="og:title" content="@yield('title', config('app.name'))"/>
  <meta property="og:description" content="@yield('description', config('app.description'))"/>
  <meta property="og:image" content="{{ request()->root() }}/img/logo.png"/>
  <meta property="article:author" content=""/>
  <meta property="og:locale" content="en_US"/>
  <!--Twitter Tags-->
  <meta name="twitter:card" content="summary"/>
  <meta name="twitter:site" content="{{ '@' . config('app.name') }}"/>
  <meta name="twitter:title" content="@yield('title', config('app.name'))"/>
  <meta name="twitter:description" content="@yield('description', config('app.description'))"/>
  <meta name="twitter:image" content="{{ request()->root() }}/img/logo.png"/>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @include('includes.inc-scripts')

    <link href="{{ asset('css/root.css') }}" rel="stylesheet">

</head>

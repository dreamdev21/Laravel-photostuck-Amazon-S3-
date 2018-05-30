<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.head')

<body>
    <div id="app">
        <div id="header">
          @include('layouts.header')
        </div>
        <div id="wrapper">
          @yield('content')
        </div>
        <div id="footer">
          @include('layouts.footer')
        </div>
    </div>
</body>
</html>

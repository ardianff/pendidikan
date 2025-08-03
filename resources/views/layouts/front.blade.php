<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.front.styles')
    @stack('styles')
</head>

<body>
    @include('partials.front.preload')
    @include('partials.front.mouse')
    @include('partials.front.top')
    @include('partials.front.offcanvas')
    @include('partials.front.header')
    @include('partials.front.search')
    @yield('content')
    @include('partials.front.footer')

    @include('partials.front.scripts')
    @include('partials.gtag')
    @stack('scripts')
</body>

</html>

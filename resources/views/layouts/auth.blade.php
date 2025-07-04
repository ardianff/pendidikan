<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" data-kt-theme="true" dir="ltr">

<head>
    @include('partials.auth.styles')
    @stack('styles')
</head>

<body>
    <div class="page-wrapper">
        @yield('content')
    </div>
    @include('partials.auth.scripts')
    @include('partials.gtag')
    @stack('scripts')

</body>

</html>

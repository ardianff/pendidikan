<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.app.styles')
    @stack('styles')
</head>

<body {{-- onload="startTime()" --}}>
    @include('partials.load')
    @include('partials.top')
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('partials.app.header')
        <div class="page-body-wrapper">
            @include('partials.app.sidebar')
            @yield('content')
            @include('partials.app.footer')

        </div>
    </div>
    @include('partials.app.scripts')
    @include('partials.gtag')
    @stack('scripts')
</body>

</html>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0">Copyright {{ Carbon\Carbon::now()->year }} © {{ config('app.name') }}
                    V{{ config('app.version') }} |
                    {{ config('app.author') }}</p>
            </div>
        </div>
    </div>
</footer>

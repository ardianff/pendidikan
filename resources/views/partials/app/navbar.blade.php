<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>{{ ucwords(Request::segment(2) . ' | Madrasah ' . Request::segment(3)) }}</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <svg class="stroke-icon">
                                <use href="{{ url('assets/svg/icon-sprite.svg') }}#stroke-home"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">{{ ucwords(Request::segment(2)) }}</li>
                    <li class="breadcrumb-item active">{{ ucwords(Request::segment(3)) }}</li>
                </ol>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->

@extends('layouts.app')
@section('title', 'Madrasah - Adiwiyata')
@section('content')
    <div class="page-body">
        @include('partials.app.navbar')

        <div class="container-fluid autofill-data-tables">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0 card-no-border">
                            <button class="btn btn-success-gradien btn-md" data-bs-toggle="modal"
                                data-bs-target="#staticBackdropBpjs">
                                Tambah
                            </button>
                            @include('pages.menu.kelembagaan.adiwiyata.modal.add')
                            <div id="editModal"></div>
                        </div>
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar row-selection">
                                <table class="display table-striped" id="full-row">
                                    <thead>
                                        <tr>
                                            <th width="5px">No</th>
                                            <th width="10px">NSM</th>
                                            <th width="10px">NPSN</th>
                                            <th width="150px">Nama</th>
                                            <th width="150px">Kota/Kab</th>
                                            <th width="200px">Jenjang</th>
                                            <th width="200px">Tahun</th>
                                            <th width="200px">Tingkat</th>
                                            <th width="200px">Terbentuk Tim</th>
                                            <th width="200px">SK</th>
                                            <th width="auto">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col-sm-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.page-body -->
@endsection

@push('styles')
    @include('partials.app.datatables.styles')
@endpush

@push('scripts')
    @include('partials.app.datatables.scripts')
    @include('pages.menu.kelembagaan.adiwiyata.scripts.list')
    @include('pages.menu.kelembagaan.adiwiyata.scripts.edit')
    @include('pages.menu.kelembagaan.adiwiyata.scripts.btn-edit')
    @include('pages.menu.kelembagaan.adiwiyata.scripts.btn-delete')
    @stack('scripts-modal')
@endpush

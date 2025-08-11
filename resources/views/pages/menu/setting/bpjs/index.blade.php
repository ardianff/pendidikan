@extends('layouts.app')
@section('title', 'Setting BPJS')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ ucwords(Request::segment(2)) . ' ' . strtoupper(Request::segment(3)) }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ url('assets/svg/icon-sprite.svg') }}#stroke-home"></use>
                                    </svg></a>
                            </li>
                            <li class="breadcrumb-item">{{ ucwords(Request::segment(2)) }}</li>
                            <li class="breadcrumb-item active">{{ ucwords(Request::segment(3)) }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid autofill-data-tables">
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0 card-no-border">
                            <button class="btn btn-success-gradien btn-md" data-bs-toggle="modal"
                                data-bs-target="#staticBackdropBpjs">Tambah</button>
                            @include('pages.menu.setting.bpjs.modal.add')
                        </div>
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar row-selection">
                                <table class="display table-striped" id="full-row">
                                    <thead>
                                        <tr>
                                            <th width="5px">No</th>
                                            <th width="150px">Jenis</th>
                                            <th width="200px">Value</th>
                                            <th width="auto">Waktu</th>
                                            <th width="auto">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection

@push('styles')
    @include('partials.app.datatables.styles')
@endpush
@push('scripts')
    @include('partials.app.datatables.scripts')
    <script>
        $(function() {
            if ($.fn.DataTable.isDataTable('#full-row')) {
                $('#full-row').DataTable().clear().destroy();
            }
            $('#full-row').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('menu.setting.bpjs.data') }}",
                    type: 'GET',
                    error: function(xhr) {
                        const res = xhr.responseJSON || {};
                        const msg = res.message || 'Terjadi kesalahan';
                        const errs = Array.isArray(res.errors) ?
                            res.errors.map(e => `<li>${e}</li>`).join('') :
                            '';

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            html: `
              <p>${msg}</p>
              ${errs ? `<ul style="text-align:left;margin-top:1em;">${errs}</ul>` : ''}
            `
                        });
                    }
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: (data, type, row, meta) =>
                            meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'value',
                        name: 'value'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                responsive: true,
            });
        });
    </script>
    @stack('scripts-modal')
@endpush

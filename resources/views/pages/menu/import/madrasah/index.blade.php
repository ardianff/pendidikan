@extends('layouts.app')
@section('title', 'Import Data Madrasah')
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
        <div class="container-fluid candidate-wrapper">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="form-import">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xl col-md-4 col-sm-6">
                                        <label class="form-label">Jenjang</label><select class="form-select form-select-sm"
                                            name="jenjang" id="jenjang" aria-label="Select Jenjang">
                                            <option value="">--Pilih--</option>
                                            @foreach ($jenjang as $jen)
                                                <option value="{{ $jen->id }}">{{ $jen->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl col-md-4 col-sm-6">
                                        <label class="form-label">File Excel</label>
                                        <input type="file" name="file_dokumen" id="file_dokumen"
                                            class="form-control form-control-sm"
                                            accept=".xlsx, .xls, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div>

                                    <div class="col common-f-start"><button class="btn btn-warning btn-sm f-w-500"
                                            type="submit">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body candidates-box px-0">
                            <div class="table-responsive custom-scrollbar">
                                <table class="table" id="candidates-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NSM</th>
                                            <th>NPSN</th>
                                            <th>Nama</th>
                                            <th>Jenjang</th>
                                            <th>Status</th>
                                            <th>Kota\Kab</th>
                                            <th>Kecamatan</th>
                                            <th>Afiliasi</th>
                                            <th>Status Upload</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
    {{-- @include('partials.app.datatables.styles') --}}
@endpush
@push('scripts')
    @include('partials.app.datatables.v2.scripts')
    <script>
        $('#form-import').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('menu.import.madrasah.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend() {
                    Swal.fire({
                        title: 'Mohon tunggu…',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success(response) {
                    Swal.close();
                    $form[0].reset();
                    const rows = [];

                    $.each(response.data, function(index, item) {
                        let statusBadge = '';
                        if (item.status === 'Berhasil') {
                            statusBadge = '<span class="badge badge-light-success">Berhasil</span>';
                        } else if (item.status === 'Gagal') {
                            statusBadge = '<span class="badge badge-light-danger">Gagal</span>';
                        } else if (item.status === 'Duplikat') {
                            statusBadge = '<span class="badge badge-light-warning">Duplikat</span>';
                        } else {
                            statusBadge = '-';
                        }

                        rows.push([
                            index + 1, // Index + 1 for the row number
                            item.data.nsm ? item.data.nsm :
                            '-', // Check if nsm is null, then display '-'
                            item.data.npsn ? item.data.npsn :
                            '-', // Check if npsn is null, then display '-'
                            item.data.nama_madrasah ? item.data.nama_madrasah :
                            '-', // Check if nama is null, then display '-'
                            item.data.jenjang ? item.data.jenjang :
                            '-', // Check if jenjang is null, then display '-'
                            item.data.status ? item.data.status :
                            '-', // Check if jenjang is null, then display '-'
                            item.data.kabupaten ? item.data.kabupaten :
                            '-', // Check if kab_kota is null, then display '-'
                            item.data.kecamatan ? item.data.kecamatan :
                            '-', // Check if kecamatan is null, then display '-'
                            item.data.afiliasi_organisasi ? item.data.afiliasi_organisasi :
                            '-', // Check if afiliasi_organisasi is null, then display '-'
                            statusBadge, // Check if status is null, then display '-'
                            item.keterangan ? item.keterangan :
                            '-', // Check if keterangan is null, then display '-'
                        ]);
                    });

                    if ($.fn.DataTable.isDataTable('#candidates-table')) {
                        $('#candidates-table').DataTable().clear().destroy();
                    }

                    $('#candidates-table').DataTable({
                        data: rows, // Insert the rows into DataTable
                        columns: [{
                                title: "No"
                            },
                            {
                                title: "NSM"
                            },
                            {
                                title: "NPSN"
                            },
                            {
                                title: "Nama"
                            },
                            {
                                title: "Jenjang"
                            },
                            {
                                title: "Status"
                            },
                            {
                                title: "Afiliasi"
                            },
                            {
                                title: "Kota/Kab"
                            },
                            {
                                title: "Kecamatan"
                            },
                            {
                                title: "Status Upload"
                            },
                            {
                                title: "Keterangan"
                            },
                        ],
                        responsive: true,
                        order: [
                            [0, 'asc']
                        ] // Set the initial order (status first)
                    });
                },
                error(response) {
                    Swal.close();
                    if (response.responseJSON && response.responseJSON.errors) {
                        var msg = response.responseJSON.message;
                        var errorMessages = response.responseJSON.errors;
                        var errorText = '';
                        $.each(errorMessages, function(key, value) {
                            errorText += value + '<br>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: msg,
                            html: errorText,
                            timer: 6000,
                            showConfirmButton: false
                        });
                    }
                    $('#full-row').DataTable().ajax.reload(null, false)
                }
            });
        });
    </script>

    @stack('scripts-modal')
@endpush

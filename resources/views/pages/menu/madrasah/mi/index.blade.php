@extends('layouts.app')
@section('title', 'Master Madrasah MI')
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
                                    <div class="col-xl col-md-2 col-sm-2">
                                        <label class="form-label">Kab/Kota</label>
                                        <select class="form-select form-select-sm" name="kab_kota" id="kab_kota"
                                            aria-label="Select Kab/Kota">


                                            {{-- Opsi "Semua" --}}
                                            <option value="semua" @if (auth()->user()->hasRole('kankemenag')) disabled @endif
                                                @if (old('kab_kota') === 'semua') selected @endif>Semua</option>

                                            {{-- Loop daftar kab/kota --}}
                                            @foreach ($kabkota as $kab)
                                                @php
                                                    $isKemenag = auth()->user()->hasRole('kankemenag');
                                                    $myKode = auth()->user()->kode_instutisi;
                                                    $isMyRegion = $kab->kode_kota_kab === $myKode;
                                                @endphp

                                                <option value="{{ $kab->kode_kota_kab }}" {{-- jika Kankemenag dan bukan wilayahnya sendiri, disable --}}
                                                    @if ($isKemenag && !$isMyRegion) disabled @endif
                                                    @if ((auth()->user()->hasRole('superadmin') && old('kab_kota') == $kab->kode_kota_kab) || ($isKemenag && $isMyRegion)) selected @endif>
                                                    {{ $kab->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl col-md-2 col-sm-2">
                                        <label class="form-label">Status</label><select class="form-select form-select-sm"
                                            name="status" id="status" aria-label="Select Status">
                                            <option value="semua">Semua</option>
                                            <option value="swasta">Swasta</option>
                                            <option value="negeri">Negeri</option>
                                        </select>
                                    </div>



                                    <div class="col common-f-start"><button class="btn btn-warning btn-sm f-w-500"
                                            type="submit">Filter</button>
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
                                            <th>Status</th>
                                            <th>Kota\Kab</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Afiliasi</th>
                                            <th>Aksi</th>
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
        // Fungsi ucwords untuk huruf besar di setiap kata
        function ucwords(str) {
            return str.replace(/\b\w/g, char => char.toUpperCase());
        }

        // Fungsi AJAX reusable
        function fetchMadrasah(formData = null) {
            // Jika tidak dikirimkan, ambil dari form
            if (!formData) {
                const form = $('#form-import')[0];
                formData = new FormData(form);
            }

            $.ajax({
                url: "{{ route('menu.madrasah.mi.list') }}",
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
                    const rows = [];


                    $.each(response.data, function(index, item) {
                        // let statusBadge = '-';
                        // if (item.status === 'Berhasil') {
                        //     statusBadge = '<span class="badge badge-light-success">Berhasil</span>';
                        // } else if (item.status === 'Gagal') {
                        //     statusBadge = '<span class="badge badge-light-danger">Gagal</span>';
                        // } else if (item.status === 'Duplikat') {
                        //     statusBadge = '<span class="badge badge-light-warning">Duplikat</span>';
                        // }

                        rows.push([
                            index + 1,
                            item.nsm || '-',
                            item.npsn || '-',
                            item.nama || '-',
                            item.dt_jenjang?.nama || '-',
                            item.status ? ucwords(item.status) : '-',
                            item.dt_kotakab?.nama || '-',
                            item.dt_kecamatan?.nama || '-',
                            item.dt_kelurahan?.nama || '-',
                            item.dt_afiliasi?.nama || '-',
                            item.action || '-',
                        ]);

                    });

                    if ($.fn.DataTable.isDataTable('#candidates-table')) {
                        $('#candidates-table').DataTable().clear().destroy();
                    }

                    $('#candidates-table').DataTable({
                        data: rows,
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
                                title: "Kota/Kab"
                            },
                            {
                                title: "Kecamatan"
                            },
                            {
                                title: "Kelurahan"
                            },
                            {
                                title: "Afiliasi"
                            },

                            {
                                title: "Aksi"
                            },
                        ],
                        responsive: true,
                        order: [
                            [0, 'asc']
                        ],
                        columnDefs: [{
                            targets: '_all',
                            className: 'text-center'
                        }],
                        initComplete: function() {
                            const api = this.api();

                            // Tambahkan input ke kolom-kolom tertentu (skip kolom No dan Aksi)
                            api.columns([1, 2]).every(function() {
                                const column = this;

                                // Ambil <th> dari header
                                const header = $(column.header());
                                const title = header.text().trim();

                                // Tambahkan input di bawah judul kolom
                                const input = $(
                                        '<input type="text" class="form-control form-control-sm mt-1" placeholder="Cari ' +
                                        title + '" />')
                                    .appendTo(header)
                                    .on('keyup change clear', function() {
                                        if (column.search() !== this.value) {
                                            column.search(this.value).draw();
                                        }
                                    });
                            });
                        }
                    });
                },
                error(response) {
                    Swal.close();
                    if (response.responseJSON && response.responseJSON.errors) {
                        let msg = response.responseJSON.message;
                        let errorMessages = response.responseJSON.errors;
                        let errorText = '';
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
                }
            });
        }

        // Submit form (Upload File)
        $('#form-import').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetchMadrasah(formData);
        });

        // Klik tombol filter (tanpa file)
        $('#filter-btn').on('click', function() {
            $('#file_dokumen').val(''); // kosongkan file supaya tidak dikirim
            fetchMadrasah(); // ambil data dari form
        });

        // Load awal saat page dibuka
        $(document).ready(function() {
            fetchMadrasah();
        });
    </script>
    @stack('scripts-modal')
@endpush

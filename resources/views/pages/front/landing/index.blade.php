@extends('layouts.front')
@section('title', 'Informasi Madrasah Provinsi Jawa Tengah')
@section('content')
    @include('pages.front.landing.partials.intro')
    @include('pages.front.landing.partials.slider')
    @include('pages.front.landing.partials.aboutus')
    @include('pages.front.landing.partials.infografis')
    @include('pages.front.landing.partials.work')
    @include('pages.front.landing.partials.advantage')
    @include('pages.front.landing.partials.wcu')
    @include('pages.front.landing.partials.counter')
    @include('pages.front.landing.partials.faq')
    @include('pages.front.landing.partials.testimonial')
    @include('pages.front.landing.partials.feature')
    @include('pages.front.landing.partials.pricing')
    @include('pages.front.landing.partials.cta')
    @include('pages.front.landing.partials.blog')

@endsection

@push('styles')
    {{-- @include('partials.app.datatables.styles') --}}
@endpush
@push('scripts')
    {{-- @include('partials.app.datatables.v2.scripts')
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

    @stack('scripts-modal') --}}
@endpush

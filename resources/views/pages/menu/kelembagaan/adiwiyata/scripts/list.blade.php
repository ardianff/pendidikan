<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(function() {
        if ($.fn.DataTable.isDataTable('#full-row')) {
            $('#full-row').DataTable().clear().destroy();
        }
        $('#full-row').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('menu.kelembagaan.adiwiyata.data') }}",
                type: 'GET',
                error(xhr) {
                    const res = xhr.responseJSON || {};
                    const msg = res.message || 'Terjadi kesalahan';
                    const errs = Array.isArray(res.errors) ?
                        res.errors.map(e => `<li>${e}</li>`).join('') :
                        '';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: `<p>${msg}</p>${errs?`<ul style="text-align:left;margin-top:1em;">${errs}</ul>`:''}`,
                        showConfirmButton: false,
                        timer: 6000
                    });
                }
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: (d, t, r, m) => m.row + m.settings._iDisplayStart + 1
                },

                {
                    data: 'nsm',
                    name: 'nsm'
                },
                {
                    data: 'npsn',
                    name: 'npsn'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kota_kab',
                    name: 'kota_kab'
                },
                {
                    data: 'jenjang',
                    name: 'jenjang'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'tingkat',
                    name: 'tingkat'
                },
                {
                    data: 'terbentuk_tim',
                    name: 'terbentuk_tim'
                },
                {
                    data: 'sk',
                    name: 'sk'
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
            columnDefs: [{
                targets: '_all', // semua kolom
                defaultContent: '-' // kalau datanya null/undefined
            }],
        });
    });
    $('#search-nsm').on('click', function() {
        const nsm = $('#nsm').val();
        const jenis = 'add';
        if (nsm) {
            cekMadrasah(nsm, jenis);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'NSM tidak boleh kosong',
                showConfirmButton: false,
            });
        }
    });

    function cekMadrasah(nsm, jenis) {
        $.ajax({
            url: "{{ route('services.master.madrasah') }}", // Ganti dengan route yang sesuai untuk mencari data
            type: "POST",
            data: JSON.stringify({
                nsm: nsm
            }),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Menambahkan CSRF token ke header
            },
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

                if (response.data && jenis === 'add') {
                    $('#addAdiwiyataForm #nsm').val(response.data.nsm ||
                        '');
                    $('#addAdiwiyataForm #npsn').val(response.data.npsn ||
                        '');
                    $('#addAdiwiyataForm #nama').val(response.data.nama ||
                        '');
                    $('#addAdiwiyataForm #jenjang').val(response.data.jenjang ? response.data.jenjang : '')
                        .trigger('change');
                    $('#addAdiwiyataForm #alamat').val(
                        response.data.alamat ?
                        response.data.alamat + ', Provinsi Jawa Tengah ' + (response.data.dt_kotakab
                            ?.nama || '-') +
                        ' Kec. ' + (response.data.dt_kecamatan?.nama || '-') +
                        ' Kel/Desa ' + (response.data.dt_keldesa?.nama || '-') :
                        ''
                    );

                    $('#addAdiwiyataForm #npsn').prop('disabled', true);
                    $('#addAdiwiyataForm #nama').prop('disabled', true);
                    $('#addAdiwiyataForm #jenjang').prop('disabled', true);
                    $('#addAdiwiyataForm #alamat').prop('disabled', true);
                    adjustTextareaHeight();
                }


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
                if (jenis == 'add') {
                    $('#addAdiwiyataForm #npsn').prop('disabled', false);
                    $('#addAdiwiyataForm #nama').prop('disabled', false);
                    $('#addAdiwiyataForm #jenjang').prop('disabled', false);
                    $('#addAdiwiyataForm #alamat').prop('disabled', false);

                    $('#addAdiwiyataForm #npsn').val('');
                    $('#addAdiwiyataForm #nama').val('');
                    $('#addAdiwiyataForm #jenjang').val('');
                    $('#addAdiwiyataForm #alamat').val('');
                    adjustTextareaHeight();
                } else if (jenis == 'edit') {
                    $('#editAdiwiyataForm #npsn').prop('disabled', false);
                    $('#editAdiwiyataForm #nama').prop('disabled', false);
                    $('#editAdiwiyataForm #jenjang').prop('disabled', false);
                    $('#editAdiwiyataForm #alamat').prop('disabled', false);

                    $('#editAdiwiyataForm #npsn').val('');
                    $('#editAdiwiyataForm #nama').val('');
                    $('#editAdiwiyataForm #jenjang').val('');
                    $('#editAdiwiyataForm #alamat').val('');
                    adjustTextareaHeight();
                }
            }
        });
    }

    function adjustTextareaHeight() {
        const textarea = $('#addAdiwiyataForm #alamat');
        textarea.height('auto'); // Reset height agar bisa menyesuaikan
        textarea.height(textarea[0].scrollHeight); // Set height sesuai dengan konten
    }
</script>

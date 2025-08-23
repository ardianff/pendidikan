<script>
    $('body').on('click', '#btn-delete', function() {
        const dataId = $(this).data('id');
        const dataJenis = $(this).data('jenis');

        Swal.fire({
            title: 'Anda yakin?',
            text: `Ingin menghapus jenis “${dataJenis}”?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false, // <-- matikan styling bawaan swal2
            customClass: {
                confirmButton: 'btn btn-danger', // Bootstrap merah
                cancelButton: 'btn btn-secondary' // Bootstrap abu-abu
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // jika user klik “Ya, hapus!”
                $.ajax({
                    url: "#", // ganti ke route delete
                    type: "DELETE",
                    data: {
                        _token: CSRF_TOKEN,
                        id: dataId,
                        jenis: dataJenis
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
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#full-row').DataTable().ajax.reload(null, false);
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
                    }
                });
            }
            // kalau dibatalkan, tidak terjadi apa-apa
        });
    });
</script>

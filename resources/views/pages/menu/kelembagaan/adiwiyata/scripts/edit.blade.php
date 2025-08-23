    <script>
        $(document).on('submit', '#editAdiwiyataForm', function(e) {
            e.preventDefault();
            const $form = $(this);
            const formData = new FormData(this);

            $.ajax({
                url: "#", // sesuaikan route update
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                    $form[0].reset();
                    $('#editSetting').modal('hide');
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
        });
    </script>

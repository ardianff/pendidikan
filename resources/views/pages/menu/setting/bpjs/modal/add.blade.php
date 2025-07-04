<div class="modal fade" id="staticBackdropBpjs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropBpjsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"><!-- modal-lg agar muat form -->
        <div class="modal-content">

            <!-- Card wrapper -->
            <div class="card height-equal m-3">
                <div class="card-header">
                    <h5>Tambah Data Setting BPJS</h5>
                    <p class="f-m-light mt-1">
                        Mohon diperhatikan, Jika inputan jenis sudah ada di sistem maka tidak dapat di simpan.
                    </p>
                </div>
                <div class="card-body custom-input">
                    <form class="row g-3" id="addSettingForm" class="row" action="javascript:void(0)" method="POST">

                        <div class="col-12">
                            <label class="form-label" for="first-name">Jenis</label>
                            <input class="form-control" id="first-name" type="text" aria-label="First name"
                                required />
                        </div>





                        <div class="col-12">
                            <label class="form-label" for="exampleFormControlTextarea1">Value</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="bpjs-form" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <!-- end card -->

        </div>
    </div>
</div>
@push('scripts-modal')
    <script>
        function showLoadingModal() {
            Swal.fire({
                title: 'Mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
        $('#addSettingForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: {{ ro }},
                type: "POST",
                data: formData,
                beforeSend: function(xhr) {
                    Swal.fire({
                        title: 'Mohon tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close()
                    $('#full-row').DataTable().ajax.reload(null, false)
                },
                error: function(response) {
                    Swal.close()
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
                            showConfirmButton: true
                        });
                    }
                }
            });
        });
    </script>
@endpush

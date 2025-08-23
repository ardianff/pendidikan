<div class="modal fade" id="staticBackdropBpjs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropBpjsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"><!-- modal-lg agar muat form -->
        <div class="modal-content">

            <!-- Card wrapper -->
            <div class="card height-equal m-3">
                <div class="card-header">
                    <h5>Tambah Data Madrasah Adiwiyata</h5>
                    <p class="f-m-light mt-1">
                        Harap diperhatikan: Jika madrasah yang sama sudah terdaftar di sistem pada tahun yang sama, maka
                        data tidak dapat disimpan.
                    </p>
                </div>
                <form id="addAdiwiyataForm" action="javascript:void(0)" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card-body custom-input">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" for="nsm">NSM</label>
                                <div class="input-group">
                                    <input class="form-control" id="nsm" name="nsm" type="text" required />
                                    <button class="btn btn-warning" type="button" id="search-nsm">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="npsn">NPSN</label>
                                <input class="form-control" id="npsn" name="npsn" type="text" required
                                    readonly />
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control" id="nama" name="nama" type="text" required
                                    readonly />
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="jenjang">Jenjang</label>
                                <select class="form-select" id="jenjang" name="jenjang" type="text" required>
                                    <option value="">-Pilih-</option>
                                    @foreach ($jenjang as $jen)
                                        <option value={{ $jen->id }}>{{ $jen->nama . ' (' . $jen->alias . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required readonly style="resize: none">

                                </textarea>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="tahun">Tahun</label>
                                <select class="form-select" id="tahun" name="tahun" required>
                                    <option value="">-Pilih-</option>

                                    @php
                                        // Mengambil tahun berjalan menggunakan Carbon
                                        $currentYear = \Carbon\Carbon::now()->year;
                                    @endphp
                                    @for ($year = $currentYear; $year >= 2020; $year--)
                                        <option value="{{ $year }}"
                                            {{ old('tahun', $currentYear) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="terbentuk_tim">Terbentuk Tim Adiwiyata</label>
                                <select class="form-select" id="terbentuk_tim" name="terbentuk_tim" required>
                                    <option value="">-Pilih-</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="sk_tim">SK TIM <span style="color: red;font-size:10px">
                                        wajib jika terbentuk tim</span></label>
                                <input class="form-control" id="sk_tim" name="sk_tim" type="file"
                                    accept=".pdf,.jpg,.png" />
                            </div>
                        </div>

                        <div class="card-footer text-end mt-3">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </form>

                <!-- end card -->

            </div>
        </div>
    </div>
</div>

@push('scripts-modal')
    <script>
        $(document).ready(function() {
            // Menangani perubahan dropdown
            $('#terbentuk_tim').change(function() {
                var selectedValue = $(this).val();
                var skTimInput = $('#sk_tim');

                if (selectedValue === 'Ya') {
                    // Jika "Ya", set input file sebagai required
                    skTimInput.attr('required', 'required');
                } else {
                    // Jika "Tidak", hilangkan required
                    skTimInput.removeAttr('required');
                }
            });

            // Memastikan status saat pertama kali halaman dimuat
            if ($('#terbentuk_tim').val() === 'Ya') {
                $('#sk_tim').attr('required', 'required');
            } else {
                $('#sk_tim').removeAttr('required');
            }
        });
    </script>
    <script>
        // Form submission logic
        $('#addAdiwiyataForm').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('menu.kelembagaan.adiwiyata.store') }}",
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
                    // 1. reset form
                    $form[0].reset();
                    // 2. tutup modal
                    $('#staticBackdropBpjs').modal('hide');
                    // 3. notif berhasil
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        timer: 4000,
                        showConfirmButton: false
                    });
                    // 4. reload DataTable
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
@endpush

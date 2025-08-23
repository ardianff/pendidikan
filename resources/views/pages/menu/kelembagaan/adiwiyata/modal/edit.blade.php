<div class="modal fade" id="editSetting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropBpjsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"><!-- modal-lg agar muat form -->
        <div class="modal-content">

            <!-- Card wrapper -->
            <div class="card height-equal m-3">
                <div class="card-header">
                    <h5>Edit Data Setting BPJS</h5>
                    <p class="f-m-light mt-1">
                        Mohon diperhatikan, Jika inputan jenis sudah ada di sistem maka tidak dapat di simpan.
                    </p>
                </div>
                <form id="editAdiwiyataForm"action="javascript:void(0)" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{ html()->hidden('id', Crypt::encryptString($setting->id)) }}
                    {{ html()->hidden('kode', Auth::user()->kode_faskes) }}
                    <div class="card-body custom-input">
                        <div class="row g-3" class="row">
                            <div class="col-12">
                                <label class="form-label" for="jenis">Jenis</label>
                                <input class="form-control" id="jenis" name="jenis" type="text" required
                                    value="{{ $setting->jenis }}"readonly />
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="value">Value</label>
                                <textarea class="form-control" id="value" name="value" rows="3">{{ $setting->value }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Changes</button>

                        </div>

                    </div>
                </form>

                <!-- end card -->

            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="catatanModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Harian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tugas" class="form-label">Tugas <span class="text-danger">*</span></label>
                    <select name="tugas[]" class="form-control select2" multiple="" id="tugas">
                        @foreach (getTugas() as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <small class="invalid-feedback" id="errortugas"></small>
                </div>
                <div class="form-group">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan"></textarea>
                    <small class="invalid-feedback" id="errorcatatan"></small>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="cleanInput('#catatan')">Batal</button>
                <button type="submit" class="btn btn-success" id="saveCatatan">Simpan</button>
            </div>
        </div>
    </div>
</div>

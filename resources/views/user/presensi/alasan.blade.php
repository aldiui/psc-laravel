<div class="modal fade" role="dialog" id="alasanModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan   {{ $presensi ? ($presensi->clock_out == null ? 'Presensi Keluar' : 'Sudah Presensi') : 'Presensi Masuk' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="alasan" class="form-label">Alasan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="alasan" name="alasan"></textarea>
                    <small class="invalid-feedback" id="erroralasan"></small>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanInput('#alasan')">Batal</button>
                <button type="submit" class="btn btn-success" id="saveAlasan">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="createModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="form-label">File </label>
                        <input type="file" name="file" id="file"
                        class="dropify" data-height="200">
                        <small class="invalid-feedback" id="errorfile"></small>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                        <small class="invalid-feedback" id="errortanggal_malai"></small>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai </label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        <small class="invalid-feedback" id="errortanggal_selesai"></small>
                    </div>
                    <div class="form-group">
                        <label for="tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select name="tipe" id="tipe" class="form-control">
                            <option value=""> -- Pilih tipe --</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Cuti">Cuti</option>
                        </select>
                        <small class="invalid-feedback" id="errortipe"></small>
                    </div>
                    <div class="form-group">
                        <label for="alasan" class="form-label">Alasan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alasan" name="alasan"></textarea>
                        <small class="invalid-feedback" id="erroralasan"></small>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


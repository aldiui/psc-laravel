<div class="modal fade" role="dialog" id="createModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="label-modal"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                        <small class="invalid-feedback" id="errortanggal"></small>
                    </div>
                    <div class="form-group">
                        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar Gudang Atas">Keluar Gudang Atas</option> 
                            <option value="Keluar Gudang Bawah">Keluar Gudang Bawah</option> 
                        </select>
                        <small class="invalid-feedback" id="errorjenis"></small>
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

<div class="modal fade" role="dialog" id="confirmModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="confirmData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    @method('PUT')
                    <div class="row">
                        <div class="col-5 mb-2">Tanggal Mulai</div>
                        <div class="col-7 mb-2">: <span id="tanggal_mulai"></span></div>
                        <div class="col-5 mb-2">Tanggal Selesai</div>
                        <div class="col-7 mb-2">: <span id="tanggal_selesai"></span></div>
                        <div class="col-5 mb-2">Tipe</div>
                        <div class="col-7 mb-2">: <span id="tipe"></span></div>
                        <div class="col-5 mb-2">Alasan</div>
                        <div class="col-7 mb-2">: <span id="alasan"></span></div>
                        <div class="col-12 mb-2">File</div>
                        <div class="col-12 mb-2">
                            <img id="file" class="img-fluid"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status  <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value=""> -- Pilih Status --</option>
                            <option value="1">Setujui</option>
                            <option value="2">Tolak</option>
                        </select>
                        <small class="invalid-feedback" id="errortipe"></small>
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
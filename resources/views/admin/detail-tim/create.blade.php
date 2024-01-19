<div class="modal fade" role="dialog" id="createModal">
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
                    <input type="hidden" name="tim_id" value="{{ $tim->id }}">
                    <div class="form-group">
                        <label for="user_id" class="form-label">Karyawan <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-control"></select>
                        <small class="invalid-feedback" id="erroruser_id"></small>
                    </div>
                    <div class="form-group">
                        <label for="posisi" class="form-label">Posisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="posisi" name="posisi">
                        <small class="invalid-feedback" id="errorposisi"></small>
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


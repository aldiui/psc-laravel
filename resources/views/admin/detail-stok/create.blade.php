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
                    <input type="hidden" name="stok_id" value="{{ $stok->id }}">
                    <div class="form-group">
                        <label for="barang_id" class="form-label">Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" id="barang_id" class="form-control"></select>
                        <small class="invalid-feedback" id="errorbarang_id"></small>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="qty" name="qty">
                        <small class="invalid-feedback" id="errorqty"></small>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        <small class="invalid-feedback" id="errordeskripsi"></small>
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


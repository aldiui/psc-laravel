<div class="modal fade" role="dialog" id="editModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    @method('PUT')
                    <div class="form-group">
                        <label for="image" class="form-label">Foto </label>
                        <input type="file" name="image" id="image" class="dropify" data-height="200">
                        <small class="invalid-feedback" id="errorimage"></small>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama">
                        <small class="invalid-feedback" id="errornama"></small>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email">
                        <small class="invalid-feedback" id="erroremail"></small>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password </label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="invalid-feedback" id="errorpassword"></small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password </label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation">
                        <small class="invalid-feedback" id="errorpassword_confirmation"></small>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan">
                        <small class="invalid-feedback" id="errorjabatan"></small>
                    </div>
                    <div class="form-group">
                        <label for="no_hp" class="form-label">No Hp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp">
                        <small class="invalid-feedback" id="errorno_hp"></small>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control">
                            <option value=""> -- Pilih Role --</option>
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                        <small class="invalid-feedback" id="errorrole"></small>
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

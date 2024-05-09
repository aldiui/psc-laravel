<div class="modal fade" role="dialog" id="createModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="label-modal"></span> Data @yield('title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
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
                        <label for="password" class="form-label">Password Baru <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control" name="password">
                            <div class="input-group-append">
                                <a class="btn bg-white d-flex justify-content-center align-items-center border"
                                    onclick="togglePasswordVisibility('#password', '#toggle-password'); event.preventDefault();">
                                    <i id="toggle-password" class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <small class="text-danger" id="errorpassword"></small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <div class="input-group-append">
                                <a class="btn bg-white d-flex justify-content-center align-items-center border"
                                    onclick="togglePasswordVisibility('#password_confirmation', '#toggle-password-confirmation'); event.preventDefault();">
                                    <i id="toggle-password-confirmation" class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <small class="invalid-feedback" id="errorpassword_confirmation"></small>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select name="jabatan" id="jabatan" class="form-control">
                            <option value=""> -- Pilih jabatan --</option>
                            <option value="Penanggungjawab Medis">Penanggungjawab Medis</option>
                            <option value="Koordinator / Tenaga Kesehatan">Koordinator / Tenaga Kesehatan</option>
                            <option value="Tenaga Kesehatan">Tenaga Kesehatan</option>
                            <option value="Operator">Operator</option>
                            <option value="Administrasi">Administrasi</option>
                            <option value="Koordinator driver">Koordinator driver</option>
                            <option value="Driver">Driver</option>
                        </select>
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
                            <option value="super admin">super admin</option>
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

<div class="modal fade" role="dialog" id="createModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="karyawan" name="karyawan" disabled>
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="text" class="form-control" id="tanggal" name="tanggal" disabled>
                    </div>
                    <div class="form-group">
                        <label for="jam_masuk" class="form-label">Jam Masuk <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="jam_masuk" name="jam_masuk">
                        <small class="invalid-feedback" id="errorjam_masuk"></small>
                    </div>
                    <div class="form-group">
                        <label for="alasan_masuk" class="form-label">Alasan Masuk</label>
                        <small><span class="text-danger d-inline-block">* Kenapa Mengisi Alasan Presensi Masuk ? Karna
                                Anda Presensi Masuk di Luar radius !</span></small>
                        <textarea class="form-control" id="alasan_masuk" name="alasan_masuk"></textarea>
                        <small class="invalid-feedback" id="erroralasan_masuk"></small>
                    </div>
                    <div class="form-group">
                        <label for="jam_keluar" class="form-label">Jam Keluar <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="jam_keluar" name="jam_keluar">
                        <small class="invalid-feedback" id="errorjam_keluar"></small>
                    </div>
                    <div class="form-group">
                        <label for="alasan_keluar" class="form-label">Alasan Keluar</label>
                        <small><span class="text-danger d-inline-block">* Kenapa Mengisi Alasan Presensi Keluar ? Karna
                                Anda Presensi Keluar di Luar radius !</span></small>
                        <textarea class="form-control" id="alasan_keluar" name="alasan_keluar"></textarea>
                        <small class="invalid-feedback" id="erroralasan_keluar"></small>
                    </div>
                    <div class="form-group">
                        <label for="tugas" class="form-label">Tugas</label>
                        <small><span class="text-danger d-inline-block">* Jika sudah mengisi mohon jangan diisi
                                kembali</span></small>
                        <select name="tugas[]" class="form-control select2" multiple="multiple" id="tugas">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

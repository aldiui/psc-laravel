@extends('layouts.app')

@section('title', 'Profil')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/dropify/css/dropify.css') }}">
@endpush

@section('main')
    <div class="main-content mb-5 pb-5">
        <section class="section">
            <div class="section-header d-none d-lg-block">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Beranda</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Data @yield('title')</h4>
                            </div>
                            <div class="card-body">
                                <form id="updateData">
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="image" class="form-label">Foto </label>
                                        <input type="file" name="image" id="image" class="dropify"
                                            data-height="200">
                                        <small class="invalid-feedback" id="errorimage"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ Auth::user()->nama }}">
                                        <small class="invalid-feedback" id="errornama"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}">
                                        <small class="invalid-feedback" id="erroremail"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan" class="form-label">Jabatan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan"
                                            value="{{ Auth::user()->jabatan }}">
                                        <small class="invalid-feedback" id="errorjabatan"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp" class="form-label">No Hp <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                                            value="{{ Auth::user()->no_hp }}">
                                        <small class="invalid-feedback" id="errorno_hp"></small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success d-none d-lg-block">Simpan</button>
                                        <button type="submit"
                                            class="btn btn-success d-block w-100 d-lg-none">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Ubah Password</h4>
                            </div>
                            <div class="card-body">
                                <form id="updatePassword">
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="password_lama" class="form-label">Password Lama <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_lama" name="password_lama">
                                        <small class="invalid-feedback" id="errorpassword_lama"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password Baru <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        <small class="invalid-feedback" id="errorpassword"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                        <small class="invalid-feedback" id="errorpassword_confirmation"></small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success d-none d-lg-block">Simpan</button>
                                        <button type="submit"
                                            class="btn btn-success d-block w-100 d-lg-none">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card d-lg-none">
                            <div class="card-body">
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin')
                                    <a href="{{ route('admin.index') }}" class="btn btn-info  btn-block">
                                        <i class="fas fa-user"></i> Ganti Admin
                                    </a>
                                @endif
                                <a href="{{ route('logout') }}" class="btn btn-block btn-danger">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/dropify/js/dropify.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            $("#updateData").submit(function(e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const url = `{{ route('profil') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    $('#image').parent().find(".dropify-clear").trigger('click');
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, null, null, "no");
                    $(".img-navbar").css("background-image",
                        `url('/storage/img/karyawan/${response.data.image}')`);
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["nama", "email", "jabatan", "no_hp",
                        "image"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updatePassword").submit(function(e) {
                setButtonLoadingState("#updatePassword .btn.btn-success", true);
                e.preventDefault();
                const url = `{{ route('profil.password') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updatePassword .btn.btn-success", false);
                    handleSuccess(response, null, null, "no");
                    $('#updatePassword .form-control').removeClass("is-invalid").val("");
                    $('#updatePassword .invalid-feedback').html("");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updatePassword .btn.btn-success", false);
                    handleValidationErrors(error, "updatePassword", ["password_lama", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush

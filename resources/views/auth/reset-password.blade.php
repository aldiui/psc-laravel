@extends('layouts.auth')

@section('title', 'Reset Password')

@push('style')
@endpush

@section('main')
    <section class="section">
        <div class="d-flex align-items-stretch flex-wrap">
            <div
                class="col-lg-4 col-12 order-lg-1 min-vh-100 order-2 bg-white d-flex justify-content-center align-items-center">
                <div class="py-2">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/icons/icon-72x72.png') }}" alt="logo">
                    </div>
                    <h4 class="text-dark text-center mb-2 font-weight-normal">Reset Password</h4>
                    <h4 class="font-weight-bold text-dark text-center mb-2">{{ config('app.name') }}</h4>
                    <small class='text-center mb-3 d-block '>Sistem Informasi Logistik dan Kinerja</small>
                    <form id="reset-password" autocomplete="off">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $_GET['email'] }}">
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
                            <small class="text-danger" id="errorpassword_confirmation"></small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-danger btn-lg btn-icon icon-right">
                                Reset Password
                            </button>
                        </div>
                    </form>
                    <div class="text-small mt-5 text-center">
                        Hak Cipta &copy; {{ date('Y') }} <div class="bullet"></div> Dibuat Oleh <span>UBSI
                            Tasikmalaya</span>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-8 py-5 min-vh-100 background-walk-y position-relative overlay-gradient-bottom order-1"
                data-background="{{ asset('images/bg-login.jpeg') }}">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h5 class="font-weight-normal text-muted-transparent">Dinas Kesehatan Kota Tasikmalaya</h5>
                            <h5 class="font-weight-normal text-muted-transparent">PSC 119 (PUBLIC SAFETY CENTER) SICETAR
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#reset-password").submit(function(e) {
                setButtonLoadingState("#reset-password .btn.btn-danger", true, "Reset Password");
                e.preventDefault();
                const url = "{{ route('password.update') }}";
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#reset-password .btn.btn-danger", false, "Reset Password");
                    handleSuccess(response, null, null, "/");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#reset-password .btn.btn-danger", false, "Reset Password");
                    handleValidationErrors(error, "reset-password", ["email", "password",
                        "password_confirmation"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush

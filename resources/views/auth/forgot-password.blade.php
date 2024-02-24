@extends('layouts.auth')

@section('title', 'Lupa Password')

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
                    <h4 class="text-dark text-center mb-2 font-weight-normal">Lupa Password</h4>
                    <h4 class="font-weight-bold text-dark text-center mb-2">{{ config('app.name') }}</h4>
                    <small class='text-center mb-3 d-block '>Sistem Informasi Logistik dan Kinerja</small>
                    <form id="forgot-password" autocomplete="off">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control" name="email">
                            <small class="invalid-feedback" id="erroremail"></small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-danger btn-lg btn-icon icon-right">
                                Lupa Password
                            </button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-small font-weight-bold">Login sekarang</a>
                    </div>
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
            $("#forgot-password").submit(function(e) {
                setButtonLoadingState("#forgot-password .btn.btn-danger", true, "Lupa Password");
                e.preventDefault();
                const url = "{{ route('password.email') }}";
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#forgot-password .btn.btn-danger", false, "Lupa Password");
                    handleSuccess(response, null, null, "/login");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#forgot-password .btn.btn-danger", false, "Lupa Password");
                    handleValidationErrors(error, "forgot-password", ["email"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush

@extends('layouts.auth')

@section('title', 'Login')

@push('style')
@endpush

@section('main')
<section class="section">
    <div class="d-flex align-items-stretch flex-wrap">
        <div class="col-lg-4 col-12 order-lg-1 min-vh-100 order-2 bg-white d-flex justify-content-center align-items-center">
            <div class="py-2">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/icons/icon-72x72.png') }}" alt="logo">
                </div>
                <h4 class="text-dark text-center mb-3 font-weight-normal">Selamat Datang di <br> <span class="font-weight-bold">PSC 119</span>
                </h4>
                <form id="login" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email">
                        <small class="invalid-feedback" id="erroremail"></small>
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password">
                        <small class="invalid-feedback" id="errorpassword"></small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-danger btn-lg btn-icon icon-right">Login
                        </button>
                    </div>
                </form>

                <div class="text-small mt-5 text-center">
                    Copyright &copy; {{ date("Y")}} <div class="bullet"></div> Created By <span>UBSI Tasikmalaya</span>
                </div>
            </div>
        </div>
        <div class="d-none d-lg-block col-lg-8 col-12 order-lg-2 min-vh-100 background-walk-y position-relative overlay-gradient-bottom order-1"
            data-background="{{ asset('img/unsplash/login-bg.jpg') }}">
            <div class="absolute-bottom-left index-2">
                <div class="text-light p-5 pb-2">
                    <div class="mb-5 pb-3">
                        <h5 class="font-weight-normal text-muted-transparent">Tasikmalaya, Jawa Barat</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        $(document).ready(function() {
            $("#login").submit(function (e) {
                setButtonLoadingState("#login .btn.btn-danger", true, "Login");
                e.preventDefault();
                const url = "{{ route('login') }}";
                const data = new FormData(this);

                const successCallback = function (response) {
                    setButtonLoadingState("#login .btn.btn-danger", false, "Login");
                    const redirect = response.data.role == 'admin' ? '/admin' : '/';
                    handleSuccess(response, null, null, redirect);
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#login .btn.btn-danger", false, "Login");
                    handleValidationErrors(error, "login", ["email", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
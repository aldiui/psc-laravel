@extends('layouts.admin')

@section('title', 'Pengaturan')

@push('style')
    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' /> 
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
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
                                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $pengaturan->nama }}">
                                        <small class="invalid-feedback" id="errornama"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="longitude" class="form-label">Longitude <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $pengaturan->longitude }}">
                                        <small class="invalid-feedback" id="errorlongitude"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="latitude" class="form-label">Latitude <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $pengaturan->latitude }}">
                                        <small class="invalid-feedback" id="errorlatitude"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="radius" class="form-label">Radius <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="radius" name="radius" value="{{ $pengaturan->radius }}">
                                        <small class="invalid-feedback" id="errorradius"></small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellat provident ipsa quod omnis rerum cum a modi id voluptates sequi, voluptatem enim voluptas accusamus dolorum exercitationem at nihil iste! Pariatur.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>

    <script>
        $(document).ready(function() {
            $("#updateData").submit(function (e) {
                setButtonLoadingState("#updateData .btn.btn-success", true);
                e.preventDefault();
                const url = `{{ route('admin.pengaturan')}}`;
                const data = new FormData(this);

                const successCallback = function (response) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);  
                    handleSuccess(response, null, null, "no");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["nama", "longitude", "latitude", "radius"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
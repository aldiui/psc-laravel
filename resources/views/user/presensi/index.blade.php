@extends('layouts.app')

@section('title', 'Presensi')

@push('style')
    <!-- CSS Libraries -->
    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' /> 
@endpush

@section('main')
    <div class="main-content mb-5 pb-5">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="mb-2">{{ formatTanggal() }}</div>
                            <div class="mb-2" id="jam"></div>
                        </div>
                        <input type="hidden" name="location" id="location">
                        <div id="map" class="mb-3 rounded-lg" style="height: 420px; width: 100%;"></div>
                        <button type="submit" id="presensiButton" class="btn {{ $presensi ? ($presensi->clock_out == null ? 'btn-danger' : 'btn-secondary') : 'btn-success' }} btn-block" {{ $presensi ? ($presensi->clock_out == null ? '' : 'disabled') : '' }}>
                            {{ $presensi ? ($presensi->clock_out == null ? 'Presensi Keluar' : 'Sudah Presensi') : 'Presensi Masuk' }}
                        </button>                    
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('user.presensi.alasan')
@include('user.presensi.catatan')
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>

    <script>
        $(document).ready(function() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(showPosition);
            } else {
                swal("Geolocation is not supported by this browser.");
            }

            setInterval(updateJam, 1000);

            $("#presensiButton").click(function(e) {
                const textButton = "{{ $presensi ? 'Presensi Keluar' : 'Presensi Masuk' }}";
                setButtonLoadingState("#presensiButton", true, textButton);
                e.preventDefault();

                const url = "{{ route('presensi') }}";
                const data = new FormData();
                const locationValue = $("#location").val();
                const catatanValue = $("#catatan").val();
                data.append('location', locationValue);
                data.append('alasan', $("#alasan").val());
                data.append('catatan', catatanValue);

                if(textButton == "Presensi Keluar" && catatanValue.trim() === "") {
                    setButtonLoadingState("#presensiButton", false, textButton);
                    getModal('catatanModal');
                }

                const successCallback = function (response) {
                    setButtonLoadingState("#presensiButton", false, textButton);
                    handleSuccess(response, null, null, "/presensi");
                };

                const errorCallback = function (error) {
                    setButtonLoadingState("#presensiButton", false, textButton);
                    handleValidationErrors(error);
                    if(locationValue) {
                        setTimeout(function() { getModal('alasanModal'); }, 2000);
                    }
                };

                if (textButton === "Presensi Keluar" && catatanValue.trim() !== "") {
                    ajaxCall(url, "POST", data, successCallback, errorCallback);
                } else if (textButton === "Presensi Masuk") {
                    ajaxCall(url, "POST", data, successCallback, errorCallback);
                }
            });

            $("#saveAlasan").click(function() {
                const alasanValue = $("#alasan").val(); 
                setButtonLoadingState("#saveAlasan", false);
                if (alasanValue.trim() === "") {
                    $("#alasan").addClass("is-invalid");
                    $("#erroralasan").text("Alasan harus diisi");
                } else {
                    $("#presensiButton").click();
                    $("#alasanModal").modal("hide");
                }
            });

            $("#saveCatatan").click(function() {
                const catatanValue = $("#catatan").val(); 
                setButtonLoadingState("#saveCatatan", false);
                if (catatanValue.trim() === "") {
                    $("#catatan").addClass("is-invalid");
                    $("#errorcatatan").text("Catatan harus diisi");
                } else {
                    $("#presensiButton").click();
                    $("#catatanModal").modal("hide");
                }
            });
        });

        const showPosition = (position) => {
            const location = $("#location");
            location.val(position.coords.latitude + ", " + position.coords.longitude);

            const map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 20);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);

            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map).bindPopup('Anda di sini').openPopup();

            const pengaturan = "{{ $pengaturan->nama }}";
            L.marker([{{ $pengaturan->longitude }}, {{ $pengaturan->latitude }}]).addTo(map).bindPopup(pengaturan).openPopup(); 

            const circle = L.circle([{{ $pengaturan->longitude }}, {{ $pengaturan->latitude }}], {
                color: 'green',
                fillColor: 'green',
                fillOpacity: 0.5,
                radius: {{ $pengaturan->radius }}
            }).addTo(map);
        }
    </script>
@endpush
@extends('layouts.app')

@section('title', 'Presensi')

@push('style')
    <link rel='stylesheet' href={{ asset('library/leaflet/leaflet.css') }} />
@endpush

@section('main')
    <div class="main-content mb-5 pb-5">
        <input type="hidden" name="location" id="location">
        <div class="card">
            <div class="card-body text-center m-0 p-0">
                <div class="d-flex justify-content-between p-3">
                    <div class="mb-2">{{ formatTanggal() }}</div>
                    <div class="mb-2" id="jam"></div>
                </div>
                <div id="map" class="mb-3 rounded-lg mx-0" style="height: 420px; width: 100%;"></div>
                <div class="p-3">
                    <button type="submit" id="presensiButton"
                        class="btn {{ $presensi ? ($presensi->clock_out == null ? 'btn-danger' : 'btn-secondary') : 'btn-success' }} btn-block"
                        {{ $presensi ? ($presensi->clock_out == null ? '' : 'disabled') : '' }}>
                        {{ $presensi ? ($presensi->clock_out == null ? 'Presensi Keluar' : 'Sudah Presensi') : 'Presensi Masuk' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('user.presensi.alasan')
    @include('user.presensi.catatan')
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/leaflet/leaflet.js') }}"></script>

    <script>
        $(document).ready(function() {
            setInterval(updateJam, 1000);

            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(showPosition);
            } else {
                handleSimpleError("Geolocation is not supported by this browser.");
            }

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

                if (textButton == "Presensi Keluar" && catatanValue.trim() === "") {
                    setButtonLoadingState("#presensiButton", false, textButton);
                    getModal('catatanModal');
                }

                const successCallback = function(response) {
                    setButtonLoadingState("#presensiButton", false, textButton);
                    handleSuccess(response, null, null, "/");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#presensiButton", false, textButton);
                    handleValidationErrors(error);
                    if (locationValue) {
                        setTimeout(function() {
                            getModal('alasanModal');
                        }, 2000);
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

            let map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 20);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map).bindPopup('Anda di sini')
                .openPopup();

            const pengaturan = "PSC 119 SICETAR";
            L.marker([{{ $pengaturan->latitude }}, {{ $pengaturan->longitude }}]).addTo(map).bindPopup(pengaturan)
                .openPopup();

            const circle = L.circle([{{ $pengaturan->latitude }}, {{ $pengaturan->longitude }}], {
                color: 'green',
                fillColor: 'green',
                fillOpacity: 0.5,
                radius: {{ $pengaturan->radius }}
            }).addTo(map);
        }
    </script>
@endpush

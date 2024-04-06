@extends('layouts.app')

@section('title', 'Presensi')

@push('style')
    <link rel='stylesheet' href={{ asset('library/leaflet/leaflet.css') }} />
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">

    <style>
        #map {
            height: 450px;
            width: 100%;
        }
    </style>
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
                <div id="map" class="mb-3 rounded-lg mx-0"></div>
                <div class="p-3">
                    <button type="submit" id="presensiButton"
                        class="btn {{ $presensi ? ($presensi->jam_keluar == null ? 'btn-danger' : 'btn-secondary') : 'btn-success' }} btn-block"
                        {{ $presensi ? ($presensi->jam_keluar == null ? '' : 'disabled') : '' }}>
                        {{ $presensi ? ($presensi->jam_keluar == null ? 'Presensi Keluar' : 'Sudah Presensi') : 'Presensi Masuk' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('user.presensi.alasan')
    @if ($presensi)
        @include('user.presensi.catatan')
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
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
                const tugasValue = $("#tugas").val();
                data.append('location', locationValue);
                data.append('alasan', $("#alasan").val());
                data.append('tugas', tugasValue);
                data.append('catatan', $("#catatan").val());

                if (textButton == "Presensi Keluar" && tugasValue.length == 0) {
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

                if (textButton === "Presensi Keluar" && tugasValue.length > 0) {
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
                const tugasValue = $("#tugas").val();
                setButtonLoadingState("#saveCatatan", false);
                if (tugasValue.length == 0) {
                    $("#tugas").addClass("is-invalid");
                    $("#errortugas").text("Tugas harus diisi");
                } else {
                    $("#presensiButton").click();
                    $("#catatanModal").modal("hide");
                }
            });
        });

        $(".selectMultiple").select2();

        let map;
        let circle;
        let distanceLine;

        const showPosition = (position) => {
            const location = $("#location");
            location.val(position.coords.latitude + ", " + position.coords.longitude);

            const userLatLng = [position.coords.latitude, position.coords.longitude];

            if (!map) {
                map = L.map('map').setView(userLatLng, 20);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
            } else {
                map.setView(userLatLng);
            }

            const pengaturan = {
                latitude: {{ $pengaturan->latitude }},
                longitude: {{ $pengaturan->longitude }},
                nama: "{{ $pengaturan->nama }}",
                radius: {{ $pengaturan->radius }}
            };
            const pengaturanLatLng = [pengaturan.latitude, pengaturan.longitude];

            if (!circle) {
                L.marker(pengaturanLatLng).addTo(map).bindPopup(pengaturan.nama).openPopup();
                circle = L.circle(pengaturanLatLng, {
                    color: 'green',
                    fillColor: 'green',
                    fillOpacity: 0.3,
                    radius: pengaturan.radius
                }).addTo(map);
            }

            if (distanceLine) {
                map.removeLayer(distanceLine);
            }

            const lineCoordinates = [userLatLng, pengaturanLatLng];
            distanceLine = L.polyline(lineCoordinates, {
                color: 'red'
            }).addTo(map);

            L.marker(userLatLng).addTo(map).bindPopup('Anda di sini').openPopup();
        };
    </script>
@endpush

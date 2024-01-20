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
                        <div class="mb-2">{{ date('d F Y') }}</div>
                        <div class="mb-2" id="jam"></div>
                    </div>
                    <input type="hidden" name="location" id="location">
                    <div id="map" class="mb-3 rounded-lg" style="height: 420px; width: 100%;"></div>
                    <button id="presensiButton" class="btn btn-success btn-block">{{  $presensi ? 'Presensi Keluar' : 'Presensi Masuk' }}</button>
                </div>
            </div>
        </div>
    </section>
</div>
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
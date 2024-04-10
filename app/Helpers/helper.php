<?php

use App\Models\User;
use Carbon\Carbon;

if (!function_exists('calculateDistance')) {
    function calculateDistance($latPresesensi, $lonPresesensi, $latSetting, $lonSetting)
    {
        if (!is_numeric($latPresesensi) || !is_numeric($lonPresesensi) || !is_numeric($latSetting) || !is_numeric($lonSetting)) {
            throw new InvalidArgumentException('Invalid input. Latitude and longitude should be numeric.');
        }

        if ($latPresesensi < -90 || $latPresesensi > 90 || $latSetting < -90 || $latSetting > 90 || $lonPresesensi < -180 || $lonPresesensi > 180 || $lonSetting < -180 || $lonSetting > 180) {
            throw new InvalidArgumentException('Invalid input. Latitude should be between -90 and 90, and longitude should be between -180 and 180.');
        }

        $latPresesensiRad = deg2rad($latPresesensi);
        $lonPresesensiRad = deg2rad($lonPresesensi);
        $latSettingRad = deg2rad($latSetting);
        $lonSettingRad = deg2rad($lonSetting);

        $deltaLat = $latSettingRad - $latPresesensiRad;
        $deltaLon = $lonSettingRad - $lonPresesensiRad;
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($latPresesensiRad) * cos($latSettingRad) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = 6371 * $c;

        return $distance * 1000;
    }
}

if (!function_exists('calculateSelisihJarak')) {
    function calculateSelisihJarak($selisih)
    {
        return ($selisih < 1000) ? $selisih . ' meter' : round($selisih / 1000, 2) . ' km';
    }
}

if (!function_exists('statusBadge')) {
    function statusBadge($status)
    {
        if ($status == '0') {
            return "<span class='badge badge-warning'><i class='far fa-clock mr-1'></i> Menunggu</span>";
        } elseif ($status == '1') {
            return "<span class='badge badge-success'><i class='far fa-check-circle mr-1'></i> Disetujui</span>";
        } elseif ($status == '2') {
            return "<span class='badge badge-danger'><i class='far fa-times-circle mr-1'></i> Ditolak</span>";
        } else {
            return "<span class='badge badge-secondary'><i class='fas fa-drafting-compass mr-1'></i> Draft</span>";
        }
    }
}

if (!function_exists('jenisBadge')) {
    function jenisBadge($jenis)
    {
        $jenisClass = ($jenis == 'Masuk Gudang Atas') ? 'badge-success' : (($jenis == 'Masuk Gudang Bawah') ? 'badge-warning' : 'badge-danger');

        return "<span class='badge $jenisClass'><i class='fas fa-plus-square mr-1'></i> $jenis</span>";
    }
}

if (!function_exists('generateBase64Image')) {
    function generateBase64Image($imagePath)
    {
        if (file_exists($imagePath)) {
            $data = file_get_contents($imagePath);
            $type = pathinfo($imagePath, PATHINFO_EXTENSION);
            $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);

            return $base64Image;
        } else {
            return '';
        }
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal($tanggal = null, $format = 'l, j F Y')
    {
        $parsedDate = Carbon::parse($tanggal)->locale('id')->settings(['formatFunction' => 'translatedFormat']);
        return $parsedDate->format($format);
    }
}

if (!function_exists('getGreeting')) {
    function getGreeting()
    {
        $hour = now()->hour;

        if ($hour >= 5 && $hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 17) {
            return 'Selamat Siang';
        } elseif ($hour >= 17 && $hour < 20) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
}

function generatePresensiColumn($presensi, $tipe)
{
    if ($tipe == 'masuk') {
        if ($presensi->jam_masuk) {
            return '
            <div>
                <div class="mb-2">
                    <span class="badge badge-success"><i class="far fa-clock"></i> ' . $presensi->jam_masuk . '</span>
                </div>
                <div class="mb-2">' . ($presensi->alasan_masuk ? "<span class='text-danger font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Diluar Radius </span>" : "<span class='text-success font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Dalam Radius </span>") . '</div>
                <div class="mb-2">' . ($presensi->alasan_masuk ? "<span>Keterangan : " . $presensi->alasan_masuk . "</span>" : "") . '</div>
            </div>';
        } else {
            return '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum Presensi</span>';
        }
    } elseif ($tipe = 'keluar') {
        if ($presensi->jam_keluar) {
            return '
            <div>
                <div class="mb-2">
                    <span class="badge badge-success"><i class="far fa-clock"></i> ' . $presensi->jam_keluar . '</span>
                </div>
                <div class="mb-2">' . ($presensi->alasan_keluar ? "<span class='text-danger font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Diluar Radius </span>" : "<span class='text-success font-weight-bold'><i class='fas fa-map-marker-alt mr-1'></i> Dalam Radius </span>") . '</div>
                <div class="mb-2">' . ($presensi->alasan_keluar ? "<span>Keterangan : " . $presensi->alasan_keluar . "</span>" : "") . '</div>
            </div>';
        } else {
            return '<span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Belum Presensi</span>';
        }
    }
}

if (!function_exists('getTugas')) {
    function getTugas()
    {
        $tugas = [
            // PJ unit drivers
            "Melakukan Pengecekan kesiapan Rutin Seluruh Unit saat Memulai bertugas",
            "Menginventarisir semua aset unit baik medis maupun non medis",
            "Berkolaborasi dengan tim medis untuk Pengecekan alat kesehatan Medis ",
            "Menjaga Kebersihan dan kerapihan Unit baik mesin maupun body kendaraan",
            "Berkolaborasi dengan tim drivers bilamana ada yang perlu diidentifikasi",
            "Berkoordinasi secara berjenjang dengan katim dan tim medis untuk kesiapan dan kendala unit",
            "Menjalankan aktivitas sesuai SOP berkendara dan berlalu lintas",
            "Berkoordinasi dengan Koordinator bila mana ada kendala dalam pelaksanaan yang tidak selesai dalam tim",
            // PJ Anggota Tim
            "Melaksanakan Aplusan shift dari tim sebelumnya",
            "Melaksanakan Ngaji dan Dzikir rutin sebelum menjalankan aktivitas",
            "Melaksanakan Pengecekan alat kesehatan dan unit serta melaporkan hasil pengecekan ke katim",
            "Melaksanakan penanganan Kegawatdaruratan dan evakuasi sesuai SOP",
            "Membuat Pelaporan dan dokumentasi kegiatan ke katim",
            // PJ Admin
            "Menyiapkan seluruh lembar anamnesa tim medis, lembar ceklis dan Pemakaian Alkes",
            "Melaksanakan Perintah langsung dari Koordinator dan ketua Pelaksana",
            "Berkolaborasi dengan PJ Alkes untuk Melakukan Stock Opname secara berkala",
            "Melakukan pengarsipan seluruh dokumen PSC baik softcopy maupun hardcopy",
            "Berkolaborasi dengan PJ Alkes Melaksanakan perekapan data keluar masuk alkes",
            "Melakukan Perekapan absensi rutin bulanan",
            "Melakukan Perekapan rutin laporan kegiatan bulanan dari tim",
            "Melaksanakan proses pengajuan dan pencairan gaji karyawan bulanan",
            "Berkoordinasi dengan koordinator bila ada kendala dalam pelaksanaan ",
            // PJ Koordinator
            "Menyusun Program dan Perencanaan kegiatan Bulanan",
            "Memantau Seluruh Pelaksanaan Kegiatan dari seluruh PJ dan Katim",
            "Berkoordinasi dengan seluruh Katim dan PJ Untuk Membahas Kendala",
            "Berkoordinasi dengan admin untuk membahas kendala administrasi",
            "Melakukan Koordinasi lintas sektor dan lintas terkait",
            "Melaksanakan Evaluasi bulanan untuk mengidentifikasi kendala Pelaksanaan",
            "Berkolaborasi dengan admin untuk membuat laporan bulanan (absensi & kegiatan)",
        ];

        return $tugas;
    }
}

if (!function_exists('stringToArray')) {
    function stringToArray($string)
    {
        return explode(',', $string);
    }
}

if (!function_exists('bulan')) {
    function bulan()
    {
        return [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
    }
}

if (!function_exists('kirimNotifikasi')) {
    function kirimNotifikasi($title, $body, $fcmTokens)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = env('SERVER_KEY_FIREBASE');

        $data = [
            "notification" => [
                "title" => $title,
                "body" => $body,

            ],
        ];

        if (is_array($fcmTokens)) {
            $data["registration_ids"] = $fcmTokens;
        } else {
            $data["to"] = $fcmTokens;
        }

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('getSuperAdmin')) {
    function getSuperAdmin()
    {
        $superAdmin = User::where('role', 'super admin')->oldest()->first();
        return $superAdmin;
    }
}

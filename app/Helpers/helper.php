<?php

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
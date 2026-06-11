<?php
// Fungsi sederhana untuk mengambil variabel environment (jika nanti dibutuhkan)
function env($key, $default = null) {
    return $_ENV[$key] ?? $default;
}
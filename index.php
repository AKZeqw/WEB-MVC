<?php
// File: CloneMVC/index.php

// Dapatkan path absolut ke folder public
$publicPath = __DIR__ . '/public/index.php';

// Pastikan file public/index.php ada
if (file_exists($publicPath)) {
    require_once $publicPath;
} else {
    die('❌ File public/index.php tidak ditemukan!');
}

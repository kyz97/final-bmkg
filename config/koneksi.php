<?php
$host     = "localhost";
$username = "kahfi";
$password = "534412mkh";
$database = "db_magang";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
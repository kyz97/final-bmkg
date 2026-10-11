<?php
include 'config/koneksi.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Data_Peserta_PKL.csv');

$output = fopen("php://output", "w");

fputcsv($output, array('No', 'Tanggal Masuk', 'Kegiatan', 'Kampus/Sekolah', 'No. Kontak', 'Waktu', 'Nama Lengkap', 'NISN/NIM', 'Judul Penelitian', 'Status'));

$query = "SELECT * FROM peserta_magang ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

$no = 1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, array(
            $no++,
            $row['tgl_masuk'],
            $row['kegiatan'],
            $row['kampus_sekolah'],
            $row['no_kontak'],
            $row['waktu'],
            $row['nama'],
            $row['nisn_nim'],
            $row['judul_penelitian'],
            $row['status']
        ));
    }
}

fclose($output);
exit();
?>
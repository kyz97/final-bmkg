<?php
include 'config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama             = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nisn_nim         = mysqli_real_escape_string($koneksi, $_POST['nisn_nim']);
    $no_kontak        = mysqli_real_escape_string($koneksi, $_POST['no_kontak']);
    $kampus_sekolah   = mysqli_real_escape_string($koneksi, $_POST['kampus_sekolah']);
    $kegiatan         = mysqli_real_escape_string($koneksi, $_POST['kegiatan']);
    $tgl_masuk        = mysqli_real_escape_string($koneksi, $_POST['tgl_masuk']);
    $tgl_selesai      = mysqli_real_escape_string($koneksi, $_POST['tgl_selesai']);
    $judul_penelitian = mysqli_real_escape_string($koneksi, $_POST['judul_penelitian']);
    
    $waktu = $tgl_masuk;
    if (!empty($tgl_selesai)) {
        $waktu = $tgl_masuk . " s.d " . $tgl_selesai;
    }

    $query_insert = "INSERT INTO peserta_magang 
                    (tgl_masuk, kegiatan, kampus_sekolah, no_kontak, waktu, nama, nisn_nim, judul_penelitian, status) 
                    VALUES 
                    ('$tgl_masuk', '$kegiatan', '$kampus_sekolah', '$no_kontak', '$waktu', '$nama', '$nisn_nim', '$judul_penelitian', 'Aktif')";

    if (mysqli_query($koneksi, $query_insert)) {
        echo "<script>
                alert('Data diri berhasil dikirim!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $query_insert . "<br>" . mysqli_error($koneksi);
    }
}
?>
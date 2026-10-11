<?php
// Panggil koneksi
include 'config/koneksi.php';

// Cek apakah ada ID yang dikirimkan via URL (GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Pastikan ID adalah angka untuk keamanan tambahan (mencegah SQL Injection ringan)
    $id = intval($id);

    // Query untuk menghapus data berdasarkan ID
    $query_hapus = "DELETE FROM peserta_magang WHERE id = $id";

    if (mysqli_query($koneksi, $query_hapus)) {
        // Jika berhasil, beri pesan alert dan kembalikan ke halaman admin
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'admin.php';
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location.href = 'admin.php';
              </script>";
    }
} else {
    // Jika tidak ada ID, kembalikan ke halaman admin
    header("Location: admin.php");
    exit();
}
?>
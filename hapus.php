<?php
include 'config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $id = intval($id);

    $query_hapus = "DELETE FROM peserta_magang WHERE id = $id";

    if (mysqli_query($koneksi, $query_hapus)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location.href = 'admin.php';
              </script>";
    }
} else {
    header("Location: admin.php");
    exit();
}
?>
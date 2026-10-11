<?php
include 'config/koneksi.php';

// --- PROSES SIMPAN PERUBAHAN ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id               = $_POST['id'];
    $nama             = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nisn_nim         = mysqli_real_escape_string($koneksi, $_POST['nisn_nim']);
    $no_kontak        = mysqli_real_escape_string($koneksi, $_POST['no_kontak']);
    $kampus_sekolah   = mysqli_real_escape_string($koneksi, $_POST['kampus_sekolah']);
    $kegiatan         = mysqli_real_escape_string($koneksi, $_POST['kegiatan']);
    $waktu            = mysqli_real_escape_string($koneksi, $_POST['waktu']);
    $judul_penelitian = mysqli_real_escape_string($koneksi, $_POST['judul_penelitian']);
    $status           = mysqli_real_escape_string($koneksi, $_POST['status']);

    $query_update = "UPDATE peserta_magang SET 
                        nama = '$nama', 
                        nisn_nim = '$nisn_nim', 
                        no_kontak = '$no_kontak', 
                        kampus_sekolah = '$kampus_sekolah', 
                        kegiatan = '$kegiatan', 
                        waktu = '$waktu', 
                        judul_penelitian = '$judul_penelitian',
                        status = '$status'
                     WHERE id = $id";

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    exit;
}

// --- MENGAMBIL DATA LAMA UNTUK DITAMPILKAN DI FORM ---
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM peserta_magang WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Data - Logbook PKL</title>
<link rel="stylesheet" href="style.css">
</head>
<body style="padding: 40px; background-color: #f7f9fa;">

<main class="lebar" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
  <h2>Edit Data Peserta</h2>
  <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #eee;">
  
  <form action="" method="POST">
    <!-- Input hidden untuk mengirim ID ke proses UPDATE -->
    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
    
    <div class="grid" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr;">
        <div style="grid-column: 1 / -1;">
            <label>Nama Lengkap</label><br>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>NISN / NIM</label><br>
            <input type="text" name="nisn_nim" value="<?php echo htmlspecialchars($data['nisn_nim']); ?>" required style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Asal Kampus / Sekolah</label><br>
            <input type="text" name="kampus_sekolah" value="<?php echo htmlspecialchars($data['kampus_sekolah']); ?>" required style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>No. Kontak</label><br>
            <input type="text" name="no_kontak" value="<?php echo htmlspecialchars($data['no_kontak']); ?>" style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Kegiatan</label><br>
            <input type="text" name="kegiatan" value="<?php echo htmlspecialchars($data['kegiatan']); ?>" style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Rentang Waktu PKL</label><br>
            <input type="text" name="waktu" value="<?php echo htmlspecialchars($data['waktu']); ?>" style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Status</label><br>
            <select name="status" style="width: 100%; padding: 8px;">
                <option value="Aktif" <?php echo ($data['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                <option value="Selesai" <?php echo ($data['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
            </select>
        </div>
        <div style="grid-column: 1 / -1;">
            <label>Judul Penelitian / Laporan</label><br>
            <input type="text" name="judul_penelitian" value="<?php echo htmlspecialchars($data['judul_penelitian']); ?>" style="width: 100%; padding: 8px;">
        </div>
    </div>

    <div style="margin-top: 30px;">
        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="admin.php" class="btn ghost" style="text-decoration: none; padding: 10px 20px; border: 1px solid #ccc; border-radius: 5px; color: black;">Batal</a>
    </div>
  </form>
</main>

</body>
</html>
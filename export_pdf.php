<?php
include 'config/koneksi.php';

$query = "SELECT * FROM peserta_magang ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export PDF - Data PKL BBMKG</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #e0e0e0; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Data Logbook Peserta PKL & Penelitian</h2>
        <p>Badan Meteorologi, Klimatologi, dan Geofisika (BBMKG) Wilayah II</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Kegiatan</th>
                <th>Kampus/Sekolah</th>
                <th>Waktu</th>
                <th>Nama Lengkap</th>
                <th>NISN/NIM</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['tgl_masuk']; ?></td>
                    <td><?php echo $row['kegiatan']; ?></td>
                    <td><?php echo $row['kampus_sekolah']; ?></td>
                    <td><?php echo $row['waktu']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['nisn_nim']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php 
                } 
            } 
            ?>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
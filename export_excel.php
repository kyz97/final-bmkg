<?php
include 'config/koneksi.php';

header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Peserta_PKL.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th style="background-color: #f2f2f2;">No</th>
            <th style="background-color: #f2f2f2;">Tanggal Masuk</th>
            <th style="background-color: #f2f2f2;">Kegiatan</th>
            <th style="background-color: #f2f2f2;">Kampus/Sekolah</th>
            <th style="background-color: #f2f2f2;">No. Kontak</th>
            <th style="background-color: #f2f2f2;">Waktu</th>
            <th style="background-color: #f2f2f2;">Nama Lengkap</th>
            <th style="background-color: #f2f2f2;">NISN/NIM</th>
            <th style="background-color: #f2f2f2;">Judul Penelitian</th>
            <th style="background-color: #f2f2f2;">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM peserta_magang ORDER BY id DESC";
        $result = mysqli_query($koneksi, $query);
        $no = 1;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['tgl_masuk'] . "</td>";
                echo "<td>" . $row['kegiatan'] . "</td>";
                echo "<td>" . $row['kampus_sekolah'] . "</td>";
                echo "<td>" . $row['no_kontak'] . "</td>";
                echo "<td>" . $row['waktu'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>'" . $row['nisn_nim'] . "</td>"; 
                echo "<td>" . $row['judul_penelitian'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>
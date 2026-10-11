<?php
include 'config/koneksi.php';

$query = "SELECT * FROM peserta_magang ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin - Logbook PKL BBMKG Wilayah II</title>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<header class="atas">
  <div>
    <p class="instansi">BBMKG Wilayah II</p>
    <h1>Logbook PKL, panel admin</h1>
  </div>
  <button id="keluar" class="btn sm ghost" onclick="keluar()">Keluar</button>
</header>
<div class="rekam penuh"><canvas id="seismo" aria-hidden="true"></canvas></div>

<main class="lebar">
  <section id="login" hidden>
    <div class="login-card">
      <h2>Masuk dulu ya</h2>
      <p class="sub">Halaman ini khusus admin. Pakai akun yang sudah didaftarkan.</p>
      <div class="full">
        <label for="email">Email</label>
        <input id="email" type="email" autocomplete="username">
      </div>
      <div class="full" style="margin-top:20px">
        <label for="password">Password</label>
        <input id="password" type="password" autocomplete="current-password">
      </div>
      <p id="login-error" class="galat" role="alert"></p>
      <div class="actions"><button class="btn" onclick="masuk()">Masuk</button></div>
    </div>
  </section>

  <section id="panel">
    <h2>Data peserta</h2>

<div class="toolbar" style="display: flex; width: 100%; gap: 10px;">
  <input id="cari" type="search" placeholder="Cari nama, NISN, kampus, atau judul" oninput="cariData()" aria-label="Cari data" style="flex: 1; width: 80%;">
  
  <select class="btn ghost" onchange="pilihUnduh(this.value)" style="cursor: pointer; appearance: auto; width: 20%;">
    <option value="" disabled selected>Unduh Data...</option>
    <option value="csv">Format CSV</option>
    <option value="excel">Format Excel</option>
    <option value="pdf">Format PDF</option>
  </select>
</div>

    <div class="table-wrap">
      <table>
        <colgroup>
          <col style="width:4%"><col style="width:9%"><col style="width:7%"><col style="width:11%">
          <col style="width:9%"><col style="width:11%"><col style="width:10%"><col style="width:9%">
          <!-- Lebar kolom aksi disesuaikan agar tombol Edit dan Hapus sejajar -->
          <col style="width:13%"><col style="width:7%"><col style="width:10%">
        </colgroup>
        <thead>
          <tr>
            <th>No</th><th>Tgl. masuk</th><th>Kegiatan</th><th>Kampus / sekolah</th>
            <th>No. kontak</th><th>Waktu</th><th>Nama</th><th>NISN / NIM</th>
            <th>Judul penelitian / laporan</th><th>Status</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tbody">
            <?php 
            $no = 1;
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['tgl_masuk']); ?></td>
                    <td><?php echo htmlspecialchars($row['kegiatan']); ?></td>
                    <td><?php echo htmlspecialchars($row['kampus_sekolah']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_kontak']); ?></td>
                    <td><?php echo htmlspecialchars($row['waktu']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['nisn_nim']); ?></td>
                    <td><?php echo htmlspecialchars($row['judul_penelitian']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <!-- Menambahkan flexbox agar tombol Edit & Hapus sejajar ke samping -->
                    <td style="display: flex; gap: 5px; flex-wrap: nowrap; border-bottom: none;">
                        <button class="btn sm" onclick="editData(<?php echo $row['id']; ?>)">Edit</button>
                        <button class="btn sm ghost" style="color: #d32f2f; border-color: #d32f2f;" onclick="hapusData(<?php echo $row['id']; ?>)">Hapus</button>
                    </td>
                </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='11' style='text-align:center;'>Belum ada data pendaftar</td></tr>";
            }
            ?>
        </tbody>
      </table>
    </div>
  </section>
</main>

<div class="toast" id="toast" role="status"></div>

<script src="seismograf.js"></script>

<script>

    function pilihUnduh(format) {
        if (format === 'csv') {
            window.location.href = 'export_csv.php';
        } else if (format === 'excel') {
            window.location.href = 'export_excel.php';
        } else if (format === 'pdf') {
            window.open('export_pdf.php', '_blank');
        }
        
        document.querySelector('select').selectedIndex = 0;
    }

    function editData(id) {
        window.location.href = 'edit.php?id=' + id;
    }

    // Fungsi konfirmasi dan mengarahkan ke hapus.php
    function hapusData(id) {
        if (confirm("Yakin ingin menghapus data ini?")) {
            window.location.href = 'hapus.php?id=' + id;
        }
    }
</script>
</body>
</html>
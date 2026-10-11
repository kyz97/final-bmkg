<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Isi Data Diri - Logbook PKL BBMKG Wilayah II</title>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<main class="halaman">
  <aside class="sampul">
    <p class="instansi">BBMKG Wilayah II</p>
    <h1>Logbook<br>Kegiatan PKL</h1>
    <svg class="coretan" viewBox="0 0 220 14" aria-hidden="true">
      <path pathLength="1" d="M2 8 C 20 0, 30 14, 50 7 S 85 1, 105 8 S 140 14, 160 6 S 200 2, 218 8" fill="none" stroke="#f26a1b" stroke-width="3.5" stroke-linecap="round"/>
    </svg>
    <p class="pengantar">Isi data dirimu sekali saja. Begitu terkirim, admin langsung bisa melihatnya di tabel logbook.</p>
    <div class="rekam"><canvas id="seismo" aria-hidden="true"></canvas></div>
  </aside>

  <section class="lembar">
    <h2>Data dirimu</h2>
    <p class="sub">Kolom bertanda bintang wajib diisi.</p>

    <form action="proses_input.php" method="POST">
      <div class="grid">
        <div class="full">
          <label for="nama">Nama lengkap *</label>
          <input id="nama" name="nama" maxlength="100" placeholder="Contoh: Fidelia Alfafi" autocomplete="name" required>
        </div>
        <div>
          <label for="nisn">NISN / NIM *</label>
          <input id="nisn" name="nisn_nim" maxlength="30" inputmode="numeric" placeholder="221010506255" required>
        </div>
        <div>
          <label for="kontak">No. HP yang bisa dihubungi</label>
          <input id="kontak" name="no_kontak" maxlength="20" type="tel" inputmode="tel" placeholder="081234567890">
        </div>
        <div class="full">
          <label for="kampus">Asal kampus / sekolah *</label>
          <input id="kampus" name="kampus_sekolah" maxlength="150" placeholder="Contoh: Universitas Pamulang" required>
        </div>
        <div class="full">
          <label>Kegiatan yang kamu ikuti</label>
          <div class="radios">
            <label><input type="radio" name="kegiatan" value="PKL" checked> PKL</label>
            <label><input type="radio" name="kegiatan" value="Penelitian"> Penelitian</label>
          </div>
        </div>
        <div>
          <label for="mulai">Mulai tanggal *</label>
          <input id="mulai" name="tgl_masuk" type="date" required>
        </div>
        <div>
          <label for="selesai">Sampai tanggal</label>
          <input id="selesai" name="tgl_selesai" type="date">
          <p class="hint">Kosongkan kalau belum tahu.</p>
        </div>
        <div class="full">
          <label for="judul">Judul penelitian / laporan</label>
          <input id="judul" name="judul_penelitian" maxlength="300" placeholder="Boleh dikosongkan dulu">
        </div>
      </div>

      <div class="actions">
        <button type="submit" class="btn">Kirim data</button>
        <button type="reset" class="btn ghost">Kosongkan</button>
      </div>
    </form>
  </section>
</main>

<div class="toast" id="toast" role="status"></div>

<script src="seismograf.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Tangkap semua input
    const inputs = document.querySelectorAll('input');
    
    inputs.forEach(input => {
      input.addEventListener('input', function() {
        // Log ini akan muncul di console browser setiap kamu ngetik
        console.log('Sedang ngetik, mengirim getaran...'); 
        
        if (typeof window.getarkan === 'function') {
            window.getarkan(1.5); // Kekuatannya saya naikkan jadi 1.5 biar lebih terlihat
        } else {
            console.error('Fungsi getarkan tidak ditemukan!');
        }
      });
    });
  });
</script>
</body>
</html>
</body>
</html>
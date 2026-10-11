// Logika halaman form peserta (index.html)
function resetForm(){
  ['nama','nisn','kontak','kampus','mulai','selesai','judul'].forEach(i => $(i).value = '');
  document.querySelector('input[name=kegiatan][value=PKL]').checked = true;
}

async function kirim(){
  const v = {
    nama: $('nama').value.trim(),
    nisn: $('nisn').value.trim(),
    kontak: $('kontak').value.trim(),
    kampus: $('kampus').value.trim(),
    mulai: $('mulai').value,
    selesai: $('selesai').value,
    judul: $('judul').value.trim(),
    kegiatan: document.querySelector('input[name=kegiatan]:checked').value
  };

  if(!v.nama || !v.nisn || !v.kampus || !v.mulai){
    toast('Lengkapi nama, NISN/NIM, kampus, dan tanggal mulai.', true);
    return;
  }
  if(v.selesai && v.selesai < v.mulai){
    toast('Tanggal selesai tidak boleh sebelum tanggal mulai.', true);
    return;
  }

  // Mode demo: Supabase belum disetup, simpan di browser saja
  if(!db){
    const data = demoAmbil();
    data.unshift({
      id: 'd' + Date.now(), created_at: new Date().toISOString(),
      nama: v.nama, nisn: v.nisn, kontak: v.kontak || null, kampus: v.kampus,
      kegiatan: v.kegiatan, mulai: v.mulai, selesai: v.selesai || null,
      judul: v.judul || null, status: 'On Proses'
    });
    demoSimpan(data);
    resetForm();
    toast('Mode demo: data tersimpan di browser ini saja, belum masuk database.');
    getarkan(1.2);
    return;
  }

  const tombol = $('btn-kirim');
  tombol.disabled = true;
  tombol.textContent = 'Mengirim...';

  const { error } = await db.from('peserta').insert({
    nama: v.nama, nisn: v.nisn, kontak: v.kontak || null, kampus: v.kampus,
    kegiatan: v.kegiatan, mulai: v.mulai, selesai: v.selesai || null, judul: v.judul || null
  });

  tombol.disabled = false;
  tombol.textContent = 'Kirim data';

  if(error){
    console.error(error);
    toast('Gagal mengirim data. Periksa koneksi lalu coba lagi.', true);
    return;
  }
  resetForm();
  toast('Data berhasil dikirim.');
  getarkan(1.2);
}
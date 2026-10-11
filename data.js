// Fungsi bersama untuk halaman peserta dan admin
const BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

const $ = id => document.getElementById(id);

function esc(s){
  return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
}

// "2026-08-07" -> "7 Agustus 2026"
function tgl(iso){
  if(!iso) return '';
  const [y,m,d] = iso.split('-');
  return `${+d} ${BULAN[+m-1]} ${y}`;
}

// Timestamp dari database -> tanggal lokal (zona waktu perangkat)
function tglLokal(ts){
  const t = new Date(ts);
  const p = n => String(n).padStart(2, '0');
  return tgl(`${t.getFullYear()}-${p(t.getMonth()+1)}-${p(t.getDate())}`);
}

function waktu(d){
  return `${tgl(d.mulai)} - ${d.selesai ? tgl(d.selesai) : 'Selesai'}`;
}

function cekDb(){
  if(!db){ toast('Supabase belum disetup. Isi dulu config.js.', true); return false; }
  return true;
}

function toast(msg, error){
  const t = $('toast');
  t.textContent = msg;
  t.className = 'toast tampil' + (error ? ' error' : '');
  clearTimeout(t._timer);
  t._timer = setTimeout(() => t.classList.remove('tampil'), 3000);
}

// ---- Mode demo: dipakai selama Supabase belum disetup ----
const KEY_DEMO = 'logbook_demo';
let demoCache = null;

function demoSimpan(data){
  demoCache = data;
  try { localStorage.setItem(KEY_DEMO, JSON.stringify(data)); } catch (e) {}
}

function demoAmbil(){
  try {
    const tersimpan = JSON.parse(localStorage.getItem(KEY_DEMO));
    if(Array.isArray(tersimpan)){ demoCache = tersimpan; return tersimpan; }
  } catch (e) {}
  if(demoCache) return demoCache;

  const contoh = [
    { id:'c1', created_at:'2026-10-08T03:12:00Z', nama:'Rina Aprilia', nisn:'221010506255', kontak:'081234567801', kampus:'Universitas Pamulang', kegiatan:'Penelitian', mulai:'2026-09-02', selesai:null, judul:'Pengaruh Stres Kerja dan Work Life Balance terhadap Kepuasan Kerja Pegawai', status:'On Proses' },
    { id:'c2', created_at:'2026-10-05T07:40:00Z', nama:'Dimas Prakoso', nisn:'221010503646', kontak:'081234567802', kampus:'Universitas Pamulang', kegiatan:'Penelitian', mulai:'2026-08-07', selesai:null, judul:'Analisis Komunikasi Interpersonal dalam Meningkatkan Kinerja Pegawai', status:'On Proses' },
    { id:'c3', created_at:'2026-09-29T02:05:00Z', nama:'Salsabila Nur', nisn:'0098123456', kontak:'081234567803', kampus:'SMK Informatika Ciputat', kegiatan:'PKL', mulai:'2026-09-14', selesai:'2026-12-12', judul:null, status:'On Proses' },
    { id:'c4', created_at:'2026-09-18T04:30:00Z', nama:'Bagas Wicaksono', nisn:'221010550932', kontak:null, kampus:'Universitas Pamulang', kegiatan:'Penelitian', mulai:'2026-07-10', selesai:'2026-09-10', judul:'Pengaruh Pelatihan Kerja terhadap Kompetensi Pegawai', status:'Selesai' },
    { id:'c5', created_at:'2026-09-02T01:15:00Z', nama:'Maya Putri', nisn:'0087654321', kontak:'081234567805', kampus:'SMK Muhammadiyah 3', kegiatan:'PKL', mulai:'2026-07-07', selesai:'2026-09-30', judul:'Sistem Informasi Inventaris Jaringan', status:'Selesai' }
  ];
  demoSimpan(contoh);
  return contoh;
}

// Biar error tidak diam-diam: kalau ada yang rusak, muncul pesan di layar (dan detail di Console)
window.addEventListener('error', e => { if($('toast')) toast('Ada error di halaman: ' + e.message, true); });
window.addEventListener('unhandledrejection', e => { if($('toast')) toast('Ada error: ' + (e.reason && e.reason.message || e.reason), true); });
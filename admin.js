// Logika halaman admin (admin.html): login, tampil data dari Supabase
let semua = [];
let kanal = null;

/* ---------- Login ---------- */
function tampilLogin(){
  if(!db) $('login-error').textContent = 'Supabase belum tersambung. Cek isi config.js (URL dan key).';
  $('login').hidden = false;
  $('panel').hidden = true;
  $('keluar').hidden = true;
}

async function mulaiAdmin(){
  try {
    if(!db){ bukaPanel(); return; }
    const { data } = await db.auth.getSession();
    data.session ? bukaPanel() : tampilLogin();
  } catch (e) {
    console.error(e);
    tampilLogin();
    $('login-error').textContent = 'Gagal memeriksa login. Coba buka halaman ini lewat Chrome.';
  }
}

async function masuk(){
  if(!cekDb()) return;
  $('login-error').textContent = '';
  let error;
  try {
    ({ error } = await db.auth.signInWithPassword({
      email: $('email').value.trim(),
      password: $('password').value
    }));
  } catch (e) { error = e; }
  if(error){ $('login-error').textContent = 'Email atau password salah.'; return; }
  $('password').value = '';
  bukaPanel();
}

async function keluar(){
  await db.auth.signOut();
  location.reload();
}

async function bukaPanel(){
  $('login').hidden = true;
  $('panel').hidden = false;
  $('keluar').hidden = !db;
  $('demo').hidden = !!db;
  if(await muat()) render(true);
  langganan();
}

/* ---------- Data ---------- */
async function muat(){
  if(!db){ semua = demoAmbil(); return true; }
  const { data, error } = await db.from('peserta').select('*').order('created_at', { ascending: false });
  if(error){ console.error(error); toast('Gagal memuat data.', true); return false; }
  semua = data;
  return true;
}

// Tabel update otomatis kalau ada peserta baru (realtime)
function langganan(){
  if(!db || kanal) return;
  kanal = db.channel('peserta-live')
    .on('postgres_changes', { event: '*', schema: 'public', table: 'peserta' }, async payload => {
      if(await muat()) render(false);
      if(payload.eventType === 'INSERT') getarkan(1);
    })
    .subscribe();
}

function render(animasi){
  const q = $('cari').value.toLowerCase();
  const rows = semua.filter(d =>
    [d.nama, d.nisn, d.kampus, d.judul].join(' ').toLowerCase().includes(q)
  );

  $('tbody').innerHTML = rows.length ? rows.map((d,i) => `
    <tr class="${animasi ? 'masuk' : ''}" style="--i:${i}" data-id="${d.id}">
      <td>${i+1}</td>
      <td>${tglLokal(d.created_at)}</td>
      <td>${esc(d.kegiatan)}</td>
      <td>${esc(d.kampus)}</td>
      <td>${esc(d.kontak) || '-'}</td>
      <td>${waktu(d)}</td>
      <td>${esc(d.nama)}</td>
      <td>${esc(d.nisn)}</td>
      <td>${esc(d.judul) || '-'}</td>
      <td><span class="badge ${d.status === 'Selesai' ? 'selesai' : 'proses'}">${d.status}</span></td>
      <td class="row-actions">
        <button class="btn sm ghost" onclick="ubahStatus('${d.id}')">${d.status === 'Selesai' ? 'Buka lagi' : 'Tandai selesai'}</button>
        <button class="btn sm danger" onclick="hapus('${d.id}')">Hapus</button>
      </td>
    </tr>`).join('')
    : `<tr><td colspan="11" class="empty">${q ? 'Tidak ada data yang cocok.' : 'Belum ada data peserta.'}</td></tr>`;
}

async function ubahStatus(id){
  const d = semua.find(x => x.id === id);
  if(!d) return;
  const baru = d.status === 'Selesai' ? 'On Proses' : 'Selesai';
  if(!db){ d.status = baru; demoSimpan(semua); render(false); getarkan(0.6); return; }
  const { error } = await db.from('peserta').update({ status: baru }).eq('id', id);
  if(error){ console.error(error); toast('Gagal mengubah status.', true); return; }
  d.status = baru;
  render(false);
  getarkan(0.6);
}

async function hapus(id){
  if(!confirm('Hapus data peserta ini?')) return;
  const tr = document.querySelector(`tr[data-id="${id}"]`);
  if(tr){ tr.classList.remove('masuk'); tr.classList.add('keluar'); }
  if(!db){
    getarkan(0.9);
    setTimeout(() => { semua = semua.filter(x => x.id !== id); demoSimpan(semua); render(false); }, 250);
    return;
  }
  const { error } = await db.from('peserta').delete().eq('id', id);
  if(error){ console.error(error); toast('Gagal menghapus data.', true); render(false); return; }
  getarkan(0.9);
  setTimeout(() => { semua = semua.filter(x => x.id !== id); render(false); }, 250);
}

function exportCSV(){
  const head = ['No','Tanggal masuk','Kegiatan','Kampus/Sekolah','No. kontak','Waktu','Nama','NISN/NIM','Judul','Status'];
  const lines = semua.map((d,i) =>
    [i+1, tglLokal(d.created_at), d.kegiatan, d.kampus, d.kontak, waktu(d), d.nama, d.nisn, d.judul, d.status]
      .map(c => `"${String(c ?? '').replace(/"/g,'""')}"`).join(','));
  const blob = new Blob(['\ufeff' + [head.join(','), ...lines].join('\n')], {type:'text/csv;charset=utf-8'});
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'logbook-pkl.csv';
  a.click();
}

// Mode demo: kalau form diisi di tab lain, tabel ini ikut berubah
window.addEventListener('storage', async e => {
  if(db || e.key !== KEY_DEMO) return;
  if(await muat()){ render(false); getarkan(1); }
});

$('password').addEventListener('keydown', e => { if(e.key === 'Enter') masuk(); });
mulaiAdmin();
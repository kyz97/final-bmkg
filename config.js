// Isi dua nilai ini dari Supabase: Project Settings > API
// (key yang dipakai: "anon public" atau "Publishable key". JANGAN pakai service_role / secret key)
const SUPABASE_URL = 'ISI_URL_PROJECT';
const SUPABASE_KEY = 'ISI_ANON_PUBLIC_KEY';

const BELUM_SETUP = SUPABASE_URL.startsWith('ISI_') || SUPABASE_KEY.startsWith('ISI_');
let db = null;
if(!BELUM_SETUP){
  try {
    db = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);
  } catch (e) {
    console.error('Konfigurasi Supabase tidak valid atau library gagal dimuat:', e);
  }
}
# Sistem Logbook PKL BBMKG Wilayah II

Proyek ini adalah sistem pendataan (logbook) sederhana untuk siswa/mahasiswa PKL dan magang di BBMKG Wilayah II. Awalnya project ini dibangun menggunakan HTML statis dan Supabase, namun sekarang sudah di-refactor (dirombak) menggunakan PHP Native dan MariaDB/MySQL.

## Fitur Utama
* **Form Input Data:** Halaman publik untuk peserta magang mengisi data diri.
* **Efek Seismograf Animasi:** Visualisasi getaran seismograf interaktif saat user mengetik.
* **Panel Admin:** Tabel dinamis untuk melihat seluruh data pendaftar.
* **Pencarian Real-time:** Filter pencarian data di tabel admin tanpa perlu reload halaman.
* **Export Data:** Unduh data peserta ke format CSV, Excel (.xls), dan PDF.
* **CRUD Penuh:** Admin bisa melakukan Edit dan Hapus data peserta.

---

## Persiapan (Prerequisites)
Sebelum menjalankan aplikasi ini, pastikan teman-teman sudah menginstal local server di laptop/komputer masing-masing, seperti:
* XAMPP, Laragon, atau MAMP.
* Nyalakan module Apache (untuk web server) dan MySQL/MariaDB (untuk database).

---

## Cara Instalasi & Setup Database

Karena aplikasi ini sekarang menggunakan MySQL, hal pertama yang wajib dilakukan adalah membuat databasenya. Ikuti langkah berikut:

### 1. Pindahkan Folder Project
Pastikan folder project ini berada di dalam direktori server lokal kalian:
* Jika pakai XAMPP: Taruh di folder `C:\xampp\htdocs\nama_folder_project`
* Jika pakai Laragon: Taruh di folder `C:\laragon\www\nama_folder_project`

### 2. Buat Database di phpMyAdmin
1. Buka browser dan akses: `http://localhost/phpmyadmin`
2. Klik tombol SQL di menu bagian atas.
3. Copy lalu Paste kode SQL di bawah ini, dan klik Go / Kirim:

```sql
-- 1. Membuat database baru
CREATE DATABASE IF NOT EXISTS db_magang;
USE db_magang;

-- 2. Membuat tabel peserta_magang
CREATE TABLE IF NOT EXISTS peserta_magang (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tgl_masuk DATE NOT NULL,
    kegiatan VARCHAR(100) NOT NULL,
    kampus_sekolah VARCHAR(150) NOT NULL,
    no_kontak VARCHAR(20) NOT NULL,
    waktu VARCHAR(100) NOT NULL,
    nama VARCHAR(150) NOT NULL,
    nisn_nim VARCHAR(50) NOT NULL,
    judul_penelitian TEXT,
    status VARCHAR(50) DEFAULT 'Aktif'
);
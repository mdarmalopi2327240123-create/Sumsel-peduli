# Sumsel-Peduli: Platform Penggalangan Dana

Aplikasi web modern untuk mengelola kampanye penggalangan dana di Sumatera Selatan dengan fitur lengkap dan interface yang user-friendly.

## 🎯 Fitur Utama

### ✅ Authentication & Authorization
- Sistem login/register dengan Laravel Breeze
- Role-based access control (Admin, User)
- Password hashing dan session management

### 📊 Dashboard dengan Grafik Interaktif
- Statistik real-time (total campaign, donasi, target)
- Grafik donasi per bulan (Line Chart)
- Grafik status campaign (Doughnut Chart)
- Grafik campaign per kategori (Bar Chart)
- Grafik top 5 campaign terbanyak donasi
- Menggunakan Chart.js untuk visualisasi

### 🎯 Manajemen Kampanye (CRUD)
- Buat, baca, ubah, hapus kampanye
- Upload gambar kampanye
- Tracking progress donasi real-time

### 💰 Manajemen Donasi (CRUD)
- Buat, baca, ubah, hapus donasi
- Metode pembayaran beragam
- Auto-update total terkumpul

### 📁 Manajemen Kategori (CRUD)
- Buat kategori campaign baru
- Edit dan hapus kategori
- Icon dan warna custom

### 📝 Update Kampanye (CRUD)
- Pembuat campaign bisa posting update
- Upload gambar untuk update
- Tracking history update

## 🚀 Quick Start

```bash
# Install
composer install
npm install

# Setup
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Run
php artisan serve
```

**Login:** admin@sumsel-peduli.com / password

## 📊 Database (4+ Migrations)
1. `create_campaigns_table`
2. `create_donations_table`
3. `create_categories_table`
4. `create_campaign_updates_table`
5. `add_category_id_to_campaigns_table`

## 🔧 Tech Stack
- Laravel 11
- Bootstrap 5
- Chart.js
- SQLite/MySQL
- Laravel Breeze

## 📚 Deployment
Lihat `DEPLOYMENT.md` untuk panduan lengkap.

---
**Version:** 1.0.0

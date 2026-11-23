# Kabinet Haruna - Agenda & Kegiatan Management System

Sistem manajemen agenda dan kegiatan internal Kabinet Haruna berbasis Laravel 12.

## Fitur Utama
- **Autentikasi & Role-Based Access**: Role management untuk Admin, Pengurus, dan Anggota.
- **Manajemen Kegiatan**: CRUD kegiatan, status otomatis (Akan Datang, Berlangsung, Selesai), dan filter tanggal.
- **Kalender Interaktif**: Tampilan kalender bulanan kegiatan kabinet.
- **Dashboard Admin**: Pengelolaan dan rekapitulasi kegiatan khusus admin.

---

## Cara Instalasi & Menjalankan

1. **Clone repository & masuk ke direktori**:
   ```bash
   git clone <repository-url>
   cd kabinet-haruna-main
   ```

2. **Install dependencies PHP (Composer)**:
   ```bash
   composer install
   ```

3. **Install dependencies Node.js**:
   ```bash
   npm install
   ```

4. **Salin file environment**:
   ```bash
   cp .env.example .env
   ```
   *(Sesuaikan konfigurasi database di file `.env` jika diperlukan)*

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database**:
   ```bash
   php artisan migrate
   ```

7. **Jalankan Development Server**:
   ```bash
   npm run dev
   ```
   Dan di terminal terpisah:
   ```bash
   php artisan serve
   ```

---

## Akun Login Default
Lihat daftar kredensial dan password pada file `app/Http/Controllers/AuthController.php` sesuai divisi masing-masing (contoh: password `ketua` untuk akun Ketua Kabinet, `bendahara`, `psdm`, `anggota_divisi`, dll).

---

## Testing
Untuk menjalankan test suite:
```bash
php artisan test
```

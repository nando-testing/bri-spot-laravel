# 🏦 Portal BRI SPOT KPR (Laravel 11 & MariaDB)

Web Portal Manajemen & Monitoring Alur Berkas Pemohonan KPR (Kredit Pemilikan Rumah) berbasis **Laravel 11**, database **MariaDB / MySQL**, dan tampilan UI **Vanilla CSS / Blade Template** yang modern, rapi, dan responsif.

---

## 🌟 Fitur Utama

1. **Sistem Autentikasi & Otorisasi Berbasis Role**:
   - **SO (Sales Officer)**: Registrasi berkas KPR baru & persiapan pengiriman ke RM.
   - **RM (Relationship Manager)**: Verifikasi & keputusan berkas KPR yang secara eksklusif ditugaskan di bawah namanya. RM berwenang menggeser status ke seluruh tahap alur KPR.
   - **CBM (Consumer Business Manager)**: Verifikasi kepemimpinan & persetujuan kelayakan kredit.
   - **ADK (Administrasi Kredit)**: Pengelolaan akad kredit & input Nomor Rekening Pinjaman.
   - **Developer Perumahan**: Mode monitoring *real-time* khusus berkas perumahan milik PT Developer tersebut (*Read-Only*).
   - **Super Admin**: Akses penuh pengelolaan master data & pembuatan akun pegawai baru.

2. **Pengamanan Wewenang Eksklusif (Dual-Layer Security)**:
   - Berkas di bawah wewenang pegawai/RM lain otomatis menampilkan tombol terkunci (`🔒 Dibatasi RM Lain` / `🔒 Read-Only`) lengkap dengan tooltip penjelas.
   - Penolakan di tingkat backend via Eloquent Model (`canEdit`, `canDelete`).

3. **Floating Toast Popup Notifications**:
   - Notifikasi melayang di sudut kanan atas dengan indikator ikon, efek animasi *slide-in*, dan *auto-dismiss* 6 detik.

4. **Formulir Terstruktur & Live Preview**:
   - Formulir pendaftaran terbagi menjadi 3 seksi visual dengan ikon input.
   - Live format Rupiah otomatis saat mengedit/mengisi nominal plafon kredit.
   - Pencarian data live (*live table search*) & Fitur Export Master Data ke CSV.

---

## 🛠️ Persyaratan Sistem (Requirements)

- **PHP**: 8.2 atau lebih baru
- **Composer**: 2.x
- **Database Engine**: MariaDB / MySQL (Port `3306`)

---

## 🚀 Langkah Instalasi & Menjalankan Proyek

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/USERNAME/bri-spot-kpr.git
   cd bri-spot-kpr
   ```

2. **Instal Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Konfigurasi Lingkungan (`.env`)**:
   Salin `.env.example` ke `.env` dan atur koneksi database MariaDB / MySQL Anda:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bri_spot_kpr
   DB_USERNAME=root
   DB_PASSWORD=mysql
   ```

4. **Generate App Key & Jalankan Migrasi Data**:
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di **`http://localhost:8000`**

---

## 🔑 Akun Demo Bawaan Seeder

| Username | Password | Role Jabatan | Keterangan |
| :--- | :--- | :--- | :--- |
| `budi_so` | `123456` | Sales Officer (SO) | Pendaftaran berkas KPR baru |
| `rina_rm` | `123456` | RM Penanggung Jawab | Berkas di bawah nama Rina Wijaya |
| `doni_rm` | `123456` | RM Penanggung Jawab | Berkas di bawah nama Doni Pratama |
| `hendra_cbm` | `123456` | CBM | Verifikasi keputusan kredit |
| `dewi_adk` | `123456` | ADK | Akad & Nomor Rekening Pinjaman |
| `ciputra_dev` | `123456` | Developer Perumahan | Monitoring PT. Ciputra (Read-Only) |
| `admin` | `123456` | Super Admin | Akses administratif penuh |

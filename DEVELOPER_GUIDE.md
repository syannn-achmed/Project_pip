# 📖 PANDUAN PENGEMBANG (DEVELOPER GUIDE)
## Sistem Pendukung Keputusan (SPK) Penerima Bantuan PIP Metode SAW
### Lembaga: Madrasah Ibtidaiyah Swasta (MIS) AL KAUTSAR

Selamat datang di repositori resmi **Sistem Pendukung Keputusan (SPK) Program Indonesia Pintar (PIP) MIS AL KAUTSAR**. Dokumen ini dirancang sebagai referensi teknis komprehensif bagi pengembang berikutnya agar memahami arsitektur, alur logika, standar pengkodean (*Clean Code & DRY*), manajemen identitas visual lembaga, serta potensi pengembangan fitur di masa depan.

---

## 📌 1. Ikhtisar & Tujuan Proyek

Aplikasi ini bertujuan untuk mengotomatisasi dan mendokumentasikan seleksi kelayakan siswa penerima Program Indonesia Pintar (PIP) di lingkungan **MIS AL KAUTSAR** secara transparan, obyektif, akuntabel, dan bebas dari pertimbangan subyektif.
* **Metode SPK**: *Simple Additive Weighting* (SAW) / Metode Penjumlahan Terbobot.
* **Pendekatan Rekayasa**: Arsitektur modular, *Separation of Concerns* (SoC), *Don't Repeat Yourself* (DRY), dan *Single Responsibility Principle* (SRP).

---

## 🛠️ 2. Arsitektur & Tumpukan Teknologi (Tech Stack)

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel 11.x (PHP 8.2+) | Model-View-Controller (MVC) standar industri |
| **Autentikasi & RBAC** | Laravel Breeze + Spatie Laravel Permission 6.x | Role: `admin_tu`, `kepala_sekolah`, `orang_tua` |
| **Frontend Styling** | Tailwind CSS 3.x + DaisyUI 4.x + Alpine.js | Modern, bernuansa hijau madrasah (emerald/teal), responsif, dan ringan |
| **Tipografi Portal** | **Plus Jakarta Sans** (Google Fonts) | Standar tipografi resmi instansi pemerintah, kementerian & layanan publik SPBE |
| **Pengolah Spreadsheet** | `maatwebsite/excel: ^3.1` | Import & Export data calon penerima (.xlsx, .csv) |
| **Penerbit Dokumen PDF** | `barryvdh/laravel-dompdf: ^3.1` | Cetak laporan SK pengesahan resmi ber-KOP MIS AL KAUTSAR |
| **Basis Data** | MySQL / MariaDB | Relasi relasional dengan foreign key & soft deletes |

---

## 🎨 3. Manajemen Identitas Visual, Tipografi & Standar Form

Proyek ini telah dikustomisasi secara menyeluruh dengan identitas resmi **MIS AL KAUTSAR** serta standar desain portal instansi dinas/pemerintahan:

### A. Tipografi Instansi Pemerintah (*Plus Jakarta Sans*)
Menggunakan keluarga huruf **Plus Jakarta Sans** di seluruh tata letak (*Welcome page, Admin Dashboard, Kepsek, dan Portal Orang Tua*).
* Diatur pada:
  * [`tailwind.config.js`](file:///c:/xampp/htdocs/PIP_SAW/tailwind.config.js): `fontFamily: { sans: ["'Plus Jakarta Sans'", "Inter", ...] }`
  * [`resources/css/app.css`](file:///c:/xampp/htdocs/PIP_SAW/resources/css/app.css): `@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');`

### B. Standardisasi Kontras Kolom Filter & Form
Seluruh input pencarian, dropdown select (Kelas, JK, Kriteria, Periode), dan header tabel dikonfigurasi dengan kontras tinggi (`#0f172a` / `text-slate-900`) berlatar belakang putih bersih agar teks selalu terlihat tajam dan terbaca jelas pada semua jenis monitor dan browser.

### C. Lokasi File Logo
Logo resmi tersimpan di direktori berikut:
* **Master Storage File**: `storage/app/public/logo.png`
* **Public Accessible Files**:
  * `public/storage/logo.png` (melalui storage link)
  * `public/logo.png` (salinan langsung di web root untuk akses cepat)

### D. Komponen Pemanggil Logo (`<x-application-logo>`)
Komponen terletak pada [`resources/views/components/application-logo.blade.php`](file:///c:/xampp/htdocs/PIP_SAW/resources/views/components/application-logo.blade.php).
Dilengkapi mekanisme *fail-safe* menggunakan atribut `onerror`:
```html
<img src="{{ asset('storage/logo.png') }}" 
     alt="Logo MIS AL KAUTSAR" 
     {{ $attributes->merge(['class' => 'object-contain']) }} 
     onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
```

### E. Implementasi pada Laporan PDF DomPDF
Pada cetak dokumen resmi ([`resources/views/pages/admin/laporan/pdf.blade.php`](file:///c:/xampp/htdocs/PIP_SAW/resources/views/pages/admin/laporan/pdf.blade.php)), logo disematkan menggunakan format **Base64 Data URI** agar tidak terpengaruh limitasi HTTP stream pada DomPDF.

---

## 👨‍👩‍👧‍👦 4. Manajemen Akun Orang Tua Siswa (`AkunOrtuController.php`)

Modul ini dibuat khusus untuk menyelesaikan kebutuhan pengelolaan akun wali murid:
1. **Menu Sidebar Admin TU**: Tautan menu **"Akun Orang Tua"** di sidebar admin mengarah ke [`admin.akun-ortu.index`](file:///c:/xampp/htdocs/PIP_SAW/resources/views/pages/admin/akun-ortu/index.blade.php).
2. **Fitur Pengelolaan Terpusat**:
   * Menampilkan daftar akun orang tua beserta daftar nama anak yang tertaut.
   * Menambahkan akun baru dan menautkannya ke siswa yang belum berpemilik.
   * Mengatur ulang kata sandi (*reset password*) atau memperbarui email orang tua.
   * Melepaskan tautan anak (*unlink*) atau menghapus akun.
3. **Pintasan Cepat pada Data Siswa** ([`resources/views/pages/admin/siswa/index.blade.php`](file:///c:/xampp/htdocs/PIP_SAW/resources/views/pages/admin/siswa/index.blade.php)):
   * Pada kolom **"Akun Ortu"**, siswa yang belum memiliki akun dapat dibuatkan akun login baru secara instan melalui modal pop-up dengan rekomendasi format email otomatis (`ortu.<nis>@sekolah.com`) dan kata sandi bawaan (`password123`), atau ditautkan ke akun orang tua yang telah terdaftar sebelumnya.

---

## 🔒 5. Penanganan Keamanan & Sesi Logout Anti-404

* **Masalah Sebelumnya**: Pemanggilan rute logout via GET (misal saat browser refresh atau history back) atau sesi yang kedaluwarsa sering memicu galat 404 / 405 *Method Not Allowed*. Selain itu, `redirect('/')` pada instalasi subfolder XAMPP (`localhost/PIP_SAW/public`) terkadang melempar pengguna ke *root dashboard* XAMPP.
* **Solusi yang Diterapkan**:
  * Rute logout di [`routes/auth.php`](file:///c:/xampp/htdocs/PIP_SAW/routes/auth.php) mendukung multi-metode (`Route::match(['get', 'post'], 'logout', ...)`).
  * Pada [`AuthenticatedSessionController::destroy`](file:///c:/xampp/htdocs/PIP_SAW/app/Http/Controllers/Auth/AuthenticatedSessionController.php), pengalihan menggunakan rute terdaftar `redirect()->route('login')` yang secara cerdas mendeteksi *base path* aplikasi serta menyertakan notifikasi status berhasil keluar.

---

## 🗂️ 6. Peta Struktur Folder & File Kunci

```text
PIP_SAW/
├── app/
│   ├── Exports/
│   │   └── SiswaExport.php              # Format ekspor spreadsheet siswa
│   ├── Imports/
│   │   └── SiswaImport.php              # Handler impor file Excel siswa
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php  # Metrik analitik & data agregasi admin
│   │   │   ├── PeriodeController.php    # CRUD tahun ajaran (1 periode aktif)
│   │   │   ├── KriteriaController.php   # CRUD kriteria & validasi bobot 100%
│   │   │   ├── SubKriteriaController.php# CRUD skala bobot & filter kriteria
│   │   │   ├── SiswaController.php      # CRUD siswa, foto, & trigger excel
│   │   │   ├── AkunOrtuController.php   # Manajemen & tautan akun orang tua siswa
│   │   │   ├── PenilaianController.php  # Form input nilai alternatif
│   │   │   ├── HasilSawController.php   # Eksekusi & transparansi matriks SAW
│   │   │   └── LaporanController.php    # Rekapitulasi & cetak PDF
│   │   ├── Kepsek/
│   │   │   └── DashboardController.php  # Ringkasan eksekutif & akses laporan PDF
│   │   └── Ortu/
│   │       └── DashboardController.php  # Portal pengumuman & data masking
│   ├── Models/
│   │   ├── Periode.php, Siswa.php, Kriteria.php, SubKriteria.php,
│   │   ├── Penilaian.php, HasilSaw.php, User.php
│   │   # Seluruh model dilengkapi relasi Eloquent eksplisit
│   └── Services/
│       └── SawService.php               # MESIN INTI SPK SAW (Perhitungan matematis)
├── database/
│   ├── migrations/                      # Skema tabel utama & Spatie RBAC
│   └── seeders/
│       ├── RoleAndUserSeeder.php        # Akun bawaan (Admin, Kepsek, Ortu)
│       └── DummyDataSeeder.php          # Periode aktif, 5 kriteria PIP, & siswa uji
├── public/
│   ├── logo.png                         # Asset logo MIS AL KAUTSAR
│   └── storage/                         # Symlink storage publik
├── resources/views/
│   ├── welcome.blade.php                # Landing page utama bertema MIS AL KAUTSAR
│   ├── components/
│   │   ├── admin-layout.blade.php       # Master layout sidebar & navbar admin
│   │   └── application-logo.blade.php   # Komponen logo terpusat
│   ├── layouts/
│   │   ├── app.blade.php                # Master layout Kepsek & Ortu
│   │   ├── guest.blade.php              # Layout autentikasi berlogo madrasah
│   │   └── navigation.blade.php         # Navbar user umum
│   └── pages/
│       ├── admin/
│       │   ├── akun-ortu/               # Manajemen akun orang tua
│       │   ├── siswa/                   # CRUD siswa & modal buat akun ortu
│       │   ├── periode/                 # CRUD periode seleksi
│       │   ├── kriteria/                # CRUD kriteria & bobot
│       │   ├── subkriteria/             # CRUD subkriteria rating
│       │   ├── penilaian/               # Form input nilai kriteria
│       │   ├── saw/                     # Eksekusi mesin SAW
│       │   └── laporan/                 # Rekapitulasi & cetak PDF
│       ├── kepsek/                      # View dashboard kepala madrasah
│       └── ortu/                        # View pengumuman aman privasi orang tua
└── routes/
    ├── web.php                          # Routing multi-role terlindungi middleware
    └── auth.php                         # Routing otentikasi Breeze & logout aman
```

---

## 🧮 7. Alur Kerja Logika SPK SAW (`SawService.php`)

Logika perhitungan dipisahkan secara tegas di [`app/Services/SawService.php`](file:///c:/xampp/htdocs/PIP_SAW/app/Services/SawService.php). Hal ini memastikan bahwa Controller tetap ramping (*Skinny Controller*) dan perhitungan dapat diuji secara mandiri (*Unit Testable*).

### Tahapan Matematis:
1. **Pembentukan Matriks Keputusan ($X$)**:
   Menyusun nilai riil alternatif siswa $A_i$ terhadap kriteria $C_j$:
   $$X = \begin{bmatrix} x_{11} & x_{12} & \dots & x_{1n} \\ x_{21} & x_{22} & \dots & x_{2n} \\ \vdots & \vdots & \ddots & \vdots \\ x_{m1} & x_{m2} & \dots & x_{mn} \end{bmatrix}$$

2. **Normalisasi Matriks ($R$)**:
   * **Jika Kriteria adalah Benefit** (nilai besar lebih baik, misal tanggungan):
     $$r_{ij} = \frac{x_{ij}}{\max_i(x_{ij})}$$
   * **Jika Kriteria adalah Cost** (nilai kecil lebih baik, misal penghasilan ortu):
     $$r_{ij} = \frac{\min_i(x_{ij})}{x_{ij}}$$

3. **Perhitungan Nilai Preferensi ($V$)**:
   Setiap elemen ternormalisasi dikalikan bobot kriteria ($W_j$) lalu dijumlahkan:
   $$V_i = \sum_{j=1}^{n} w_j \cdot r_{ij}$$

4. **Perangkingan & Penetapan Status**:
   * Hasil diurutkan secara *descending* (nilai $V$ terbesar menempati peringkat #1).
   * Siswa dalam batas `kuota` diberi label status **"Lolos"**, sisanya **"Tidak Lolos"**.
   * Disimpan ke tabel `hasil_saws` menggunakan `DB::transaction`.

---

## 🚀 8. Panduan Instalasi & Menjalankan Aplikasi

Jika Anda baru melakukan *clone* proyek ini ke lingkungan baru, ikuti langkah berikut:

```bash
# 1. Salin berkas lingkungan
cp .env.example .env

# 2. Pasang dependensi PHP
composer install

# 3. Generate Application Key
php artisan key:generate

# 4. Hubungkan Storage Publik (Untuk Pas Foto Siswa & Logo)
php artisan storage:link

# 5. Konfigurasikan Database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pip_saw
DB_USERNAME=root
DB_PASSWORD=

# 6. Eksekusi Migrasi & Dummy Data Bawaan
php artisan migrate:fresh --seed

# 7. Jalankan Aset Frontend & Development Server
npm run build
php artisan serve
```

### Kredensial Akun Default (Seeder)
Semua akun menggunakan kata sandi standar: **`password123`**
* **Admin Tata Usaha**: `admin@sekolah.com`
* **Kepala Madrasah**: `kepsek@sekolah.com`
* **Orang Tua Siswa**: `ortu@sekolah.com`

---

## 💡 9. Ide & Fitur yang Dapat Dikembangkan Selanjutnya (*Future Roadmap*)

Bagi pengembang berikutnya yang ingin meningkatkan skala aplikasi ini di **MIS AL KAUTSAR**, berikut adalah daftar fitur rekomendasi:

1. **Integrasi EMIS 4.0 Kemenag / Simpatika**:
   * Menambahkan sinkronisasi API data siswa dan status ekonomi keluarga langsung dari sistem pangkalan data EMIS Kemenag.
2. **Notifikasi WhatsApp Gateway**:
   * Mengintegrasikan library seperti Fonnte atau Twilio untuk mengirimkan pesan WhatsApp otomatis kepada nomor kontak orang tua pendaftar saat hasil seleksi diterbitkan.
3. **Metode Hibrid AHP-SAW (*Analytic Hierarchy Process*)**:
   * Menambahkan fitur matriks perbandingan berpasangan (*pairwise comparison*) AHP untuk menentukan bobot kriteria ($W$) secara matematis agar bobot tidak ditentukan secara subyektif oleh admin.
4. **Unggah Dokumen Berkas Digital (Scan KK, KIP & Slip Gaji)**:
   * Menambahkan form unggah bukti fisik (file PDF/JPG Kartu Keluarga, KIP, Slip Gaji) dengan pratinjau berkas in-app agar tim verifikator TU dapat melakukan audit silang keabsahan dokumen.
5. **Activity Logs & Audit Trail**:
   * Memasang paket `spatie/laravel-activitylog` untuk mencatat riwayat setiap perubahan nilai siswa, perubahan bobot kriteria, atau waktu eksekusi perhitungan.
6. **Multi-Period Analytical Comparison**:
   * Grafik tren penerima bantuan antar-tahun ajaran pada dashboard Kepala Madrasah.

## Struktur Proyek Backend Medisys

Proyek ini mengikuti pola arsitektur berlapis untuk memastikan pemisahan masalah (separation of concerns) dan kemudahan pemeliharaan. Di bawah ini adalah panduan tentang cara menyusun kode saat membuat fitur baru, dari tingkat antarmuka hingga ke titik akhir (endpoint) API.

### Gambaran Umum Arsitektur

Logika aplikasi dibagi menjadi beberapa lapisan (layer) berikut untuk memastikan kode yang bersih dan terstruktur:

1.  **Lapisan Kontroler (Controller Layer)**: Menerima permintaan HTTP dan mengembalikan respons. Ini adalah titik masuk dan keluar dari aplikasi.
2.  **Lapisan Permintaan (Request Layer)**: Menangani validasi data yang masuk pada level Controller menggunakan `FormRequest`.
3.  **Lapisan Sumber Daya (Resource Layer)**: Menangani transformasi data (model) menjadi format JSON yang akan dikirim sebagai respons.
4.  **Lapisan Layanan (Service Layer)**: Berisi logika bisnis inti aplikasi. Controller akan mendelegasikan tugas ke lapisan ini.
5.  **Lapisan Antarmuka / Repositori (Interface / Repository Layer)**: Menangani abstraksi untuk akses data, memisahkan logika bisnis dari cara data diambil atau disimpan.
6.  **DTO (Data Transfer Object)**: Objek sederhana yang digunakan untuk membawa data antar lapisan, memastikan struktur data yang konsisten.

### Struktur Direktori

Berikut adalah struktur proyek yang merepresentasikan alur untuk sebuah fitur (contoh: `HospitalInstallation`):

```
app/
├── DTOs/                                   # Objek Transfer Data
│   └── HospitalInstallation/
│       ├── HospitalInstallationQuerySchema.php
│       └── HospitalInstallationRequestSchema.php
├── Http/
│   ├── Controllers/                        # Titik Akhir API
│   │   └── MasterData/
│   │       └── HospitalInstallationController.php
│   ├── Requests/                           # Validasi Request
│   │   └── HospitalInstallation/
│   │       ├── StoreRequest.php
│   │       └── UpdateRequest.php
│   └── Resources/                          # Transformasi Response
│       └── HospitalInstallationResource.php
├── Interfaces/                             # Kontrak untuk Akses Data
│   └── HospitalInstallationInterface.php
├── Models/                                 # Model Eloquent
│   └── HospitalInstallation.php
├── Providers/                              # Service Provider (Binding DI)
│   └── AppServiceProvider.php
├── Repositories/                           # Implementasi Akses Data
│   └── HospitalInstallationRepository.php
├── Services/                               # Logika Bisnis
│   └── MasterData/
│       └── HospitalInstallationService.php
└── Utils/                                  # Utilitas Bersama
    └── Http/
        └── APIResponse.php
```

### Alur Kerja: Membuat Layanan dari Antarmuka hingga Titik Akhir

1.  **Definisikan Antarmuka (Interface)**: Buat sebuah antarmuka di `app/Interfaces` untuk mendefinisikan kontrak metode yang diperlukan untuk manipulasi data (misalnya, `find`, `findByID`, `create`, `update`).
    *   Gunakan perintah Artisan untuk membuat antarmuka baru:
        ```bash
        php artisan make:interface HospitalInstallationInterface
       
2.  **Implementasikan Repositori (Repository)**: Buat kelas repositori di `app/Repositories` yang mengimplementasikan antarmuka tersebut.
    *   Implementasikan setiap metode dari antarmuka menggunakan **Model Eloquent**.
    *   Gunakan **DTO** (dari `app/DTOs`) sebagai parameter untuk memastikan struktur data yang masuk konsisten.
    *   Gunakan perintah Artisan untuk membuat kelas repositori baru:
        ```bash
        php artisan make:class Repositories/HospitalInstallationRepository
       
3.  **Daftarkan Binding di AppServiceProvider**: Daftarkan binding antara **Antarmuka** dan **Repositori** di `app/Providers/AppServiceProvider.php` pada metode `register()`.
    ```php    // Master Data Bindings
    $this->app->bind(HospitalInstallationInterface::class, HospitalInstallationRepository::class);


Jika fitur tersebut termasuk dalam kategori **Master Data**, maka pendaftaran binding sebaiknya dilakukan di dalam `MasterDataServiceProvider`. Hal ini bertujuan untuk menjaga `AppServiceProvider` tetap bersih dan mengelompokkan ketergantungan berdasarkan konteks fiturnya.

Contoh penempatan pada `app/Providers/MasterDataServiceProvider.php`:

    ```php
        public function register(): void
        {
            // Hospital Installation
            $this->app->bind(
                \App\Interfaces\HospitalInstallationInterface::class,
                \App\Repositories\HospitalInstallationRepository::class
            );
        }
    ```

Langkah ini memungkinkan Laravel melakukan *dependency injection* secara otomatis —     ketika sebuah kelas membutuhkan `HospitalInstallationInterface`, Laravel akan menyuntikkan `HospitalInstallationRepository`.

4.  **Implementasikan Layanan (Service)**: Buat kelas layanan di `app/Services`.
    *   Suntikkan (Inject) **Antarmuka** ke dalam konstruktor Layanan.
    *   Implementasikan logika bisnis yang memanggil metode dari antarmuka/repositori.
    *   Gunakan **DTO** (dari `app/DTOs`) untuk *type-hinting* dan menyusun struktur data yang sedang diproses.

5.  **Buat Form Request**: Buat kelas `FormRequest` di `app/Http/Requests` untuk mendefinisikan aturan validasi untuk data yang masuk.

6.  **Buat Resource**: Buat kelas `JsonResource` di `app/Http/Resources` untuk mentransformasi model Eloquent menjadi struktur JSON yang akan dikembalikan sebagai respons.

7.  **Buat Kontroler (Controller)**: Buat sebuah kontroler di `app/Http/Controllers`.
    *   Suntikkan (Inject) **Layanan (Service)** ke dalam konstruktor Kontroler.
    *   Definisikan metode (titik akhir) yang memanggil metode dari layanan. Gunakan *type-hint* pada **FormRequest** untuk validasi otomatis.
    *   Ambil data hasil dari Service, lalu bungkus dengan **Resource** sebelum dikembalikan sebagai respons.

8.  **Definisikan Rute (Routes)**: Daftarkan metode kontroler di `routes/api.php` untuk mengeksposnya sebagai titik akhir (endpoint) API.

## Tentang Five Tier Diagnostic Test
Software untuk melakukan tes miskonsepsi dengan 5 tingkat pertanyaan. Dibuat dengan framework laravel 7.*

## Fitur

1. Pendaftaran Akun Siswa
2. Pembuatan Soal, Jawaban dan Alasan Jawaban
3. Pengaturan Durasi Tes
4. Export Hasil Tes Siswa

## Cara Instal

1. **Clone Repository**
```bash
git clone https://github.com/ruririzal/FiveTierDiagnosticTest.git
cd FiveTierDiagnosticTest
composer install
copy .env.example .env
```

2. **Buka ```.env``` lalu ubah baris berikut sesuai dengan databasemu yang dipakai, karena di project ini menggunakan mysql, jika kamu ingin menggunakan lainnya tinggal sesuaikan**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=five_tier_diagnostic_test
DB_USERNAME=root
```

3. **Instalasi website**
```bash
php artisan key:generate
php artisan db:fresh (because i create new command for migrate tables & run the seeder)
php artisan storage:link
```

4. **Jalankan website**
```bash
php artisan serve
```

## Default Akun Admin
- email = admin@admin.com
- password = password

## Pembuat

- LinkedIn : <a href="https://www.linkedin.com/in/ruri-fikri/"> Nur Rizal Nadif Fikri</a>
- Email : <a href="mailto:nurrizalnadiff@gmail.com"> nurrizalnadiff@gmail.com</a>

## Kontribusi

Terima kasih bagi yang ingin berkontribusi.

## Pendukung

Pembuatan software didukung oleh alif.

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

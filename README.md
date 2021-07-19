# CRUD Laravel
Aplikasi pengelolaan data mahasiswa sederhana menggunakan framework [Laravel 8](https://laravel.com/docs/8.x).

## Beberapa fitur didalamnya

 1. **CRUD** (Create, Read, Update, Delete) Data Mahasiswa dan Data Prodi
 2. **Print PDF** Data Mahasiswa
 3. **Autentikasi Admin** (Login, Register, Forgot Password)
 4. **Pengelolaan Profil Admin** (Ubah Profil, Ubah Password, Ubah Foto Profil, Hapus Akun)
 5. **Import dan Export file Ms. Excel** untuk Data Mahasiswa dan Prodi
<br>

## Prerequisite
 1. Terinstall [Composer](https://getcomposer.org/download/)
 2. Terinstall PHP 8.x (Bisa gunakan [XAMPP](https://www.apachefriends.org/download.html) versi terbaru)
<br>

## Langkah awal sebelum digunakan
 - Jalankan perintah `composer update`
 - Hilangkan tanda ' **;** ' pada `;extension=gd` di file **php.ini**
 - Buat file **.env** di direktori folder aplikasi lalu copy semua isi dari file **.env.example** dan kalian atur nama database di file **.env**
 - Buat database dengan nama yang sudah kalian atur di **.env** lalu jalankan perintah `php artisan migrate` agar otomatis dibuatkan tabelnya
<br>

## Konfigurasi
### 1. SMTP Gmail
Atur SMTP menjadi seperti ini di file **.env** 

    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@crudlaravel.com
    MAIL_FROM_NAME="${APP_NAME}"
    
Tambahkan email google kalian di `MAIL_USERNAME` dan password google kalian di `MAIL_PASSWORD`

> Kebutuhan ini hanya untuk verifikasi email pada admin yang akan mengganti password dan menghapus akunnya dengan menggunakan Gmail sebagai sarananya, tidak untuk membajak akun Google kalian


### 2. Verification Email Template
Kalian dapat mengubah tampilan dari pesan yang dikirimkan ke email untuk verifikasi email di **/resources/views/profil/mail.blade.php**
<br>
<br>

## Cara Menggunakan
Jalankan perintah `php artisan serve`
<br>
<br>

## Tanya Jawab
| Tanya | Jawab |
|--|--|
| Merubah lokasi foto admin yang diupload? | Buka **ProfilController > changePhotoProcess** lalu ubah isi dari **$path** |
| Mengatur output pada export data ke Excel? | Untuk data mahasiswa : **/resources/views/mahasiswa/export/print** dan untuk data prodi : **/resources/views/prodi/export/print** |
| Bagaimana format tabel Excel yang benar agar dapat di import? | Lihat di file **/public/excel/mahasiswa.xlsx** dan **/public/excel/prodi.xlsx** |
| Kok SMTP-nya tidak bekerja? | Buka profil akun Google kalian, kemudian ke **Security** lalu aktifkan **Less secure app access** |
<br>
<br>
Mohon maaf bila aplikasi ini sangat sederhana dan saya akan terus mengembangkan aplikasi ini menjadi lebih baik :slightly_smiling_face:

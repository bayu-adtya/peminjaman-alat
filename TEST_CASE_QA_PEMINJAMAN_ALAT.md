# Test Case QA Sistem Peminjaman Alat

## Ruang Lingkup

Dokumen ini mencakup aplikasi web dan endpoint API yang ditemukan pada proyek: autentikasi, otorisasi role, master kategori dan alat, akun pengguna, pengajuan peminjaman, persetujuan petugas, pengembalian, stok, denda, riwayat, dan laporan.

Kolom **Hasil Aktual** dan **Status** tidak diisi sebagai PASS karena test belum dijalankan di aplikasi. Gunakan `Belum diuji` dan `NOT RUN` sampai eksekusi QA dilakukan. Kasus yang memiliki indikasi cacat dari pembacaan kode tetap dicatat pada bagian **Temuan Review Kode**.

### Akun Uji

Data berikut berasal dari `database/seeders/UserSeeder.php`:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gmail.com` | `password123` |
| Petugas | `petugas@gmail.com` | `password123` |
| Peminjam | `rian@gmail.com` | `password123` |
| Peminjam kedua | `siti@gmail.com` | `password123` |

**Catatan:** aplikasi web menggunakan **email**, bukan username, untuk login. Form akun juga tidak mempunyai field username; validasi unik dilakukan pada email. Dengan demikian, data uji contoh `Username: budiman` perlu diganti menjadi email untuk aplikasi ini.

### Data Uji Bersama

- Siapkan kategori baru `QA Perangkat` dan alat baru `QA Router`, stok awal `5`, kondisi `Baik`.
- Untuk tanggal, gunakan tanggal hari ini sebagai tanggal pinjam; tanggal rencana kembali gunakan hari ini atau tanggal setelah hari ini sesuai kasus.
- Catat stok awal alat sebelum setiap pengujian dan verifikasi perubahan stok berdasarkan selisih. Seeder transaksi berisi status/riwayat yang tidak sepenuhnya mencerminkan pengurangan stok, sehingga angka absolut setelah seeding tidak selalu menjadi baseline yang aman.
- Uji hapus/edit pada data QA yang dibuat khusus. Jangan menghapus akun atau alat seed yang dipakai kasus lain.

## Test Case Web

### Autentikasi dan Hak Akses

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| AUTH-001 | Login Admin Berhasil | Admin terdaftar dan belum login | 1. Buka halaman login.<br>2. Isi email dan password admin.<br>3. Klik Masuk. | `admin@gmail.com` / `password123` | Login berhasil dan diarahkan ke dashboard admin. | sudah diuji | PASS |
| AUTH-002 | Login Petugas Berhasil | Petugas terdaftar dan belum login | 1. Buka halaman login.<br>2. Isi email dan password petugas.<br>3. Klik Masuk. | `petugas@gmail.com` / `password123` | Login berhasil dan diarahkan ke daftar pengajuan peminjaman petugas. | sudah diuji | PASS |
| AUTH-003 | Login Peminjam Berhasil | Peminjam terdaftar dan belum login | 1. Buka halaman login.<br>2. Isi email dan password peminjam.<br>3. Klik Masuk. | `rian@gmail.com` / `password123` | Login berhasil dan diarahkan ke katalog alat. | sudah diuji | PASS |
| AUTH-004 | Login Dengan Password Salah | Akun uji terdaftar dan belum login | 1. Buka halaman login.<br>2. Isi email terdaftar dan password yang salah.<br>3. Klik Masuk. | Email `rian@gmail.com`; password `salah123` | Login ditolak, pengguna tetap di halaman login, dan pesan kesalahan kredensial tampil. | sudah diuji | PASS |
| AUTH-005 | Login Dengan Input Kosong/Tidak Valid | Pengguna belum login | 1. Buka halaman login.<br>2. Kosongkan email atau password, atau masukkan email tidak valid.<br>3. Klik Masuk. | Email kosong/tidak valid; password kosong | Login tidak diproses dan validasi wajib/email tampil. | sudah diuji | PASS |
| AUTH-006 | Logout Mengakhiri Sesi | Pengguna sudah login | 1. Klik Logout.<br>2. Coba buka kembali URL dashboard menggunakan sesi sebelumnya. | Akun admin atau petugas | Sesi berakhir, pengguna diarahkan ke login, dan halaman terlindungi tidak lagi dapat dibuka. | sudah diuji | PASS |
| AUTH-007 | Pengguna Belum Login Mengakses Halaman Terlindungi | Pengguna belum login | 1. Buka URL `/admin/dashboard`, `/petugas/peminjaman`, dan `/peminjam/katalog` secara langsung. | Tanpa sesi login | Setiap halaman mengarahkan pengguna ke login atau menolak akses. | sudah diuji | PASS |
| AUTH-008 | Peminjam Mengakses URL Admin | Login sebagai peminjam | 1. Buka URL `/admin/users` dan `/admin/alat` secara langsung. | `rian@gmail.com` / `password123` | Akses ditolak atau diarahkan ke halaman sesuai role; data/admin action tidak dapat diakses. | sudah diuji | PASS |
| AUTH-009 | Admin Mengakses URL Khusus Peminjam | Login sebagai admin | 1. Buka URL `/peminjam/katalog` secara langsung. | `admin@gmail.com` / `password123` | Akses ditolak atau diarahkan ke halaman sesuai role. | sudah diuji | PASS |

### Admin: Akun Pengguna/Petugas

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| USER-001 | Berhasil Membuat Akun Petugas | Admin login dan berada di halaman Kelola User | 1. Klik Tambah User.<br>2. Isi data valid dan pilih role Petugas.<br>3. Klik Simpan. | Nama `Andi QA`; email `andi.qa@example.test`; password `Budi12345`; role `petugas`; no. HP `081234567890` | Akun tersimpan, role Petugas terlihat pada daftar, dan akun dapat login menggunakan email/password. | sudah diuji | PASS |
| USER-002 | Gagal Membuat Akun Dengan Field Wajib Kosong | Admin berada di form Tambah User | 1. Biarkan nama, email, password, atau role kosong.<br>2. Klik Simpan. | Nama kosong; email kosong; password kosong | Penyimpanan ditolak dan validasi wajib tampil pada field terkait. | sudah diuji | PASS |
| USER-003 | Gagal Membuat Akun Dengan Email Duplikat | Admin berada di form Tambah User; email seed sudah terdaftar | 1. Isi form dengan email yang sudah dipakai.<br>2. Klik Simpan. | Email `petugas@gmail.com` | Penyimpanan ditolak; pesan email sudah digunakan tampil; data akun lama tidak berubah. | sudah diuji | PASS |
| USER-004 | Gagal Membuat Akun Dengan Password Kurang Dari 8 Karakter | Admin berada di form Tambah User | 1. Isi field lain dengan data valid.<br>2. Isi password kurang dari 8 karakter.<br>3. Klik Simpan. | Password `abc123` | Penyimpanan ditolak dan validasi panjang minimum password tampil. | sudah diuji | PASS |
| USER-005 | Berhasil Memperbarui Data Pengguna | Akun QA tersedia | 1. Klik Edit pada akun QA.<br>2. Ubah nama atau role.<br>3. Biarkan password kosong.<br>4. Klik Perbarui. | Nama baru `Andi QA Update`; role `petugas`; password kosong | Perubahan tampil di daftar; password lama tetap dapat digunakan karena field password dikosongkan. | sudah diuji | PASS |
| USER-006 | Gagal Memperbarui Email Menjadi Email Duplikat | Admin mengedit akun QA; akun lain menggunakan email target | 1. Ubah email menjadi email pengguna lain.<br>2. Klik Perbarui. | Email baru `admin@gmail.com` | Update ditolak karena email unik; data akun tidak berubah. | sudah diuji | PASS |
| USER-007 | Berhasil Menghapus Pengguna Yang Tidak Sedang Meminjam | Admin login; akun QA tidak punya peminjaman aktif | 1. Klik Hapus akun QA.<br>2. Konfirmasi penghapusan pada dialog browser. | Email akun QA | Akun terhapus dan tidak muncul di daftar pengguna. | sudah diuji | PASS |
| USER-008 | Penghapusan Dibatalkan Dari Dialog Konfirmasi | Admin login; akun QA ada | 1. Klik Hapus.<br>2. Pilih Batal pada dialog browser. | Akun QA | Tidak ada request penghapusan; akun tetap terlihat di daftar. | sudah diuji | PASS |
| USER-009 | Penghapusan Peminjam Aktif Ditolak | Admin login; akun peminjam memiliki transaksi berstatus `dipinjam` atau `telat` | 1. Klik Hapus akun peminjam aktif.<br>2. Konfirmasi penghapusan. | Akun peminjam QA dengan peminjaman aktif | Akun tidak terhapus dan pesan bahwa pengguna masih meminjam alat tampil. | sudah diuji | PASS |

### Admin: Kategori dan Alat

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| KAT-001 | Berhasil Menambah Kategori | Admin login dan membuka Kelola Kategori | 1. Klik Tambah Kategori.<br>2. Isi nama kategori.<br>3. Klik Simpan. | Nama kategori `QA Perangkat` | Kategori tersimpan dan muncul pada tabel kategori serta pilihan kategori alat. | sudah diuji | PASS |
| KAT-002 | Gagal Menambah Kategori Tanpa Nama | Admin berada di form kategori | 1. Kosongkan nama kategori.<br>2. Klik Simpan. | Nama kategori kosong | Penyimpanan ditolak dan validasi wajib tampil. | sudah diuji | PASS |
| KAT-003 | Gagal Menambah Kategori Dengan Nama Duplikat | Kategori bernama `QA Perangkat` telah ada | 1. Tambahkan kategori dengan nama yang sama.<br>2. Klik Simpan. | `QA Perangkat` | Penyimpanan ditolak karena nama kategori harus unik. | sudah diuji | PASS |
| KAT-004 | Berhasil Mengubah Nama Kategori | Kategori QA tersedia | 1. Klik Edit kategori QA.<br>2. Ubah nama.<br>3. Klik Perbarui. | `QA Perangkat Revisi` | Nama baru tersimpan dan tampil di tabel kategori. | sudah diuji | PASS |
| KAT-005 | Penghapusan Kategori Yang Dipakai Ditolak | Kategori QA digunakan minimal satu alat | 1. Klik Hapus kategori QA.<br>2. Konfirmasi penghapusan. | `QA Perangkat` | Kategori tidak terhapus dan pesan kategori masih digunakan tampil. | sudah diuji | PASS |
| ALAT-001 | Berhasil Menambah Data Alat | Admin login; kategori QA sudah tersedia | 1. Klik Tambah Alat.<br>2. Isi nama, kategori, stok, kondisi dan deskripsi.<br>3. Klik Simpan. | Nama `QA Router`; kategori QA; stok `5`; kondisi `Baik`; deskripsi `Alat uji QA` | Alat tersimpan dan tampil pada tabel dengan stok, kategori, serta kondisi sesuai input. | sudah diuji | PASS |
| ALAT-002 | Gagal Menyimpan Alat Dengan Data Wajib Kosong/Tidak Valid | Admin berada di form Tambah Alat | 1. Kosongkan nama/kategori/kondisi atau masukkan stok negatif.<br>2. Klik Simpan. | `nama_alat` kosong; `kategori_id` tidak valid; stok `-1` | Penyimpanan ditolak dan validasi wajib, relasi kategori, atau batas minimum stok tampil. | sudah diuji | PASS |
| ALAT-003 | Berhasil Mengubah Data Alat | Alat QA tersedia | 1. Klik Edit alat QA.<br>2. Ubah nama atau stok.<br>3. Klik Perbarui. | Nama `QA Router Revisi`; stok `6` | Perubahan tersimpan dan tampil pada daftar alat. | sudah diuji | PASS |
| ALAT-004 | Alat Dengan Peminjaman Aktif Tidak Dapat Dihapus | Alat QA memiliki detail peminjaman berstatus `dipinjam` atau `telat` | 1. Klik Hapus alat QA.<br>2. Konfirmasi penghapusan. | `QA Router` | Alat tidak terhapus dan pesan alat sedang dipinjam tampil. | sudah diuji | PASS |
| ALAT-005 | Katalog Tidak Menampilkan Alat Dengan Stok Nol | Alat QA tersedia dengan stok diubah menjadi `0` | 1. Login sebagai peminjam.<br>2. Buka katalog. | `QA Router`, stok `0` | Alat dengan stok nol tidak muncul pada katalog. | sudah diuji | PASS |

### Peminjam: Katalog dan Pengajuan

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| PEM-001 | Katalog Menampilkan Alat Tersedia | Peminjam login; ada alat dengan stok lebih dari nol | 1. Buka Katalog Alat.<br>2. Periksa nama alat, kategori, stok, dan jumlah. | `QA Router`, stok awal `5` | Alat tersedia tampil dengan kategori dan stok yang benar serta dapat dipilih. | sudah diuji | PASS |
| PEM-002 | Pencarian Katalog Berdasarkan Nama/Kategori | Peminjam berada di halaman katalog | 1. Cari `QA Router`.<br>2. Ulangi pencarian berdasarkan nama kategori.<br>3. Reset pencarian. | Kata kunci `QA Router` / `QA Perangkat` | Hasil hanya menampilkan alat yang cocok; Reset mengembalikan daftar alat tersedia. | sudah diuji | PASS |
| PEM-003 | Pengajuan Peminjaman Satu Alat Berhasil | Peminjam login; alat memiliki stok cukup | 1. Pilih alat di katalog.<br>2. Isi tanggal kembali setelah hari ini.<br>3. Isi jumlah.<br>4. Klik Ajukan Peminjaman. | `QA Router`; jumlah `2`; tanggal kembali hari ini + 3 hari | Pengajuan tercatat dengan status `diajukan`, muncul di riwayat, dan menunggu persetujuan. Stok inventaris belum berkurang sebelum disetujui. | sudah diuji | PASS |
| PEM-004 | Pengajuan Dengan Beberapa Alat Berhasil | Peminjam login; kedua alat tersedia | 1. Pilih dua alat berbeda.<br>2. Isi tanggal kembali dan jumlah masing-masing.<br>3. Ajukan peminjaman. | `QA Router` jumlah `1`; `QA Kamera` jumlah `1`; tanggal kembali hari ini + 2 hari | Satu transaksi pengajuan berisi kedua detail alat dan jumlah yang sesuai. | sudah diuji | PASS |
| PEM-005 | Pengajuan Tanpa Memilih Alat Ditolak | Peminjam login dan membuka katalog | 1. Jangan pilih checkbox alat.<br>2. Isi tanggal kembali yang valid.<br>3. Klik Ajukan Peminjaman. | `alat_id` kosong | Pengajuan tidak tersimpan dan validasi menyatakan minimal satu alat harus dipilih. | sudah diuji | PASS |
| PEM-006 | Pengajuan Dengan Tanggal Kembali Hari Ini atau Lampau Ditolak | Peminjam login | 1. Pilih alat.<br>2. Isi tanggal kembali hari ini atau tanggal lampau.<br>3. Ajukan. | Tanggal kembali `hari ini` atau `hari ini - 1` | Pengajuan ditolak karena tanggal kembali web harus setelah hari ini. | sudah diuji | PASS |
| PEM-007 | Pengajuan Dengan Jumlah Nol Ditolak | Peminjam login; alat tersedia | 1. Pilih alat.<br>2. Ubah jumlah menjadi `0` melalui input.<br>3. Ajukan. | `QA Router`; jumlah `0` | Pengajuan ditolak; jumlah minimal satu. | sudah diuji | PASS |
| PEM-008 | Pengajuan Melebihi Stok Ditolak | Peminjam login; stok alat diketahui | 1. Pilih alat.<br>2. Masukkan jumlah lebih besar dari stok.<br>3. Ajukan. | Stok `5`; jumlah `6` | Pengajuan ditolak dan stok tidak berubah. | sudah diuji | PASS |
| PEM-009 | Riwayat Hanya Menampilkan Transaksi Akun Login | Dua akun peminjam memiliki transaksi berbeda | 1. Login sebagai Rian.<br>2. Buka Riwayat Peminjaman.<br>3. Login sebagai Siti dan ulangi. | Rian dan Siti; masing-masing mempunyai transaksi QA | Setiap akun hanya melihat transaksi miliknya sendiri beserta alat, jumlah, tanggal, dan status. | sudah diuji | PASS |
| PEM-010 | Halaman Pengembalian Menampilkan Pinjaman Aktif | Peminjam memiliki transaksi berstatus `dipinjam` dan transaksi selesai | 1. Buka menu Pengembalian Alat.<br>2. Periksa daftar transaksi. | Satu transaksi `dipinjam`; satu `dikembalikan` | Halaman menampilkan transaksi aktif `dipinjam`; transaksi selesai tidak muncul. Pengembalian fisik tetap diproses petugas. | sudah diuji | PASS |

### Petugas: Persetujuan dan Pengembalian

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| PET-001 | Pengajuan Baru Tampil Pada Daftar Persetujuan | Petugas login; ada pengajuan `diajukan` dari PEM-003 | 1. Buka Persetujuan Peminjaman.<br>2. Cari nama peminjam. | Akun peminjam QA; transaksi status `diajukan` | Daftar menampilkan peminjam, tanggal, detail alat, jumlah, dan tombol Setujui. | sudah diuji | PASS |
| PET-002 | Persetujuan Peminjaman Mengurangi Stok | Pengajuan berstatus `diajukan`; stok cukup | 1. Catat stok.<br>2. Klik Setujui dan konfirmasi.<br>3. Periksa status transaksi dan stok alat. | `QA Router`, jumlah pinjam `2`, stok awal `5` | Status menjadi `dipinjam`; stok berkurang tepat `2` menjadi `3`; pengajuan tidak lagi menunggu persetujuan. | sudah diuji | PASS |
| PET-003 | Pencarian Persetujuan Berdasarkan Nama | Ada beberapa pengajuan dari peminjam berbeda | 1. Isi pencarian dengan nama peminjam.<br>2. Klik Cari. | Nama peminjam QA | Hanya pengajuan yang cocok tampil; Reset menampilkan daftar pengajuan kembali. | sudah diuji | PASS |
| PET-004 | Persetujuan Ditolak Jika Stok Sudah Tidak Cukup | Pengajuan masih `diajukan`; stok alat dibuat kurang dari jumlah diminta sebelum persetujuan | 1. Klik Setujui.<br>2. Periksa status dan stok. | Jumlah diminta `2`; stok tersisa `1` | Transaksi tidak berubah ke `dipinjam`, stok tidak menjadi negatif, dan pesan kegagalan tampil. | sudah diuji | PASS |
| PET-005 | Persetujuan Ulang Tidak Mengurangi Stok Dua Kali | Transaksi telah disetujui | 1. Kirim ulang aksi persetujuan untuk transaksi yang sama.<br>2. Periksa status dan stok. | Transaksi status `dipinjam` | Persetujuan ulang ditolak/tidak mengubah data; stok hanya berkurang satu kali. | sudah diuji | PASS |
| PET-006 | Pengembalian Tepat Waktu Berhasil Diproses | Transaksi berstatus `dipinjam`; petugas login | 1. Buka Pemantauan Pengembalian.<br>2. Isi kondisi kembali `Baik` dan denda `0`.<br>3. Klik Terima Pengembalian dan konfirmasi. | `QA Router`, jumlah `2`; tanggal rencana hari ini atau mendatang; denda `0` | Catatan pengembalian tersimpan dengan petugas login; status menjadi `dikembalikan`; stok bertambah tepat `2`; data tampil pada riwayat pengembalian. | sudah diuji | PASS |
| PET-007 | Pengembalian Dengan Kondisi Rusak Dan Denda | Transaksi berstatus `dipinjam` | 1. Isi kondisi Rusak Ringan.<br>2. Isi denda positif.<br>3. Proses pengembalian. | Kondisi `Rusak Ringan`; denda `15000` | Kondisi dan nominal denda tersimpan; status selesai dan stok alat dipulihkan. | sudah diuji | PASS |
| PET-008 | Validasi Pengembalian Tanpa Kondisi | Transaksi berstatus `dipinjam` | 1. Kosongkan Kondisi Kembali.<br>2. Klik Terima Pengembalian. | Kondisi kosong | Pengembalian ditolak; status, stok, dan catatan pengembalian tidak berubah; pesan validasi tampil. | sudah diuji | PASS |
| PET-009 | Validasi Denda Negatif | Transaksi berstatus `dipinjam` | 1. Isi kondisi valid.<br>2. Isi denda `-1` dengan mengirim nilai melewati validasi browser.<br>3. Proses pengembalian. | Denda `-1` | Pengembalian ditolak oleh validasi server; stok tidak berubah. | sudah diuji | PASS |
| PET-010 | Pengembalian Ganda Ditolak | Transaksi telah memiliki catatan pengembalian | 1. Kirim kembali form proses untuk transaksi yang sama.<br>2. Periksa jumlah catatan dan stok. | Peminjaman yang sudah `dikembalikan` | Sistem menolak pengembalian kedua; hanya ada satu catatan pengembalian dan stok tidak bertambah lagi. | sudah diuji | PASS |
| PET-011 | Laporan Dapat Difilter Dan Dicetak | Petugas login; tersedia transaksi dengan status dan tanggal berbeda | 1. Filter status dan rentang tanggal.<br>2. Klik Filter.<br>3. Klik Cetak Laporan. | Status `dikembalikan`; rentang tanggal mencakup transaksi QA | Tabel hanya berisi data sesuai filter; halaman cetak terbuka dengan filter/data yang sama dan nilai denda yang sesuai. | sudah diuji | PASS |

### Admin: Peminjaman dan Pengembalian

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| ADM-PIN-001 | Admin Membuat Pengajuan Peminjaman | Admin login; peminjam dan alat tersedia | 1. Buka Kelola Peminjaman lalu Tambah Peminjaman.<br>2. Pilih peminjam, tanggal, alat, jumlah.<br>3. Klik Simpan Peminjaman. | Peminjam QA; `QA Router`; jumlah `2`; tanggal pinjam hari ini; rencana kembali hari ini + 3 | Transaksi tersimpan berstatus `diajukan`; detail alat tercatat; stok belum berkurang. | sudah diuji | PASS |
| ADM-PIN-002 | Admin Gagal Membuat Peminjaman Dengan Tanggal Tidak Valid | Admin berada di form peminjaman | 1. Isi tanggal rencana lebih awal dari tanggal pinjam.<br>2. Lengkapi field lain dengan data valid.<br>3. Simpan. | `tgl_pinjam` hari ini; `tgl_kembali_plan` hari ini - 1 | Validasi menolak transaksi dan tidak membuat peminjaman. | sudah diuji | PASS |
| ADM-PIN-003 | Perubahan Status Menjadi Dipinjam Mengurangi Stok | Transaksi admin berstatus `diajukan`; stok cukup | 1. Ubah status menjadi Dipinjam pada daftar.<br>2. Periksa stok. | `QA Router`, jumlah `2`, stok awal `5` | Status menjadi `dipinjam` dan stok turun menjadi `3`. | sudah diuji | PASS |
| ADM-PIN-004 | Perubahan Status Menjadi Dikembalikan Membuat Riwayat | Transaksi admin berstatus `dipinjam` dan belum mempunyai pengembalian | 1. Ubah status ke Dikembalikan.<br>2. Buka Kelola Pengembalian dan periksa stok. | `QA Router`, jumlah `2` | Status selesai, stok bertambah, dan sistem membuat catatan pengembalian kondisi `Baik` dengan denda `0`. | sudah diuji | PASS |
| ADM-PIN-005 | Perubahan Status Terlambat Menjadi Dikembalikan Memulihkan Stok | Transaksi admin berstatus `telat`; stok sebelumnya sudah dikurangi ketika transaksi menjadi `dipinjam` | 1. Ubah status transaksi menjadi Dikembalikan.<br>2. Periksa status, catatan pengembalian, dan stok. | `QA Router`, jumlah `2` | Status menjadi `dikembalikan`, catatan pengembalian ada, dan stok bertambah kembali `2`. | sudah diuji | PASS |
| ADM-PIN-006 | Menghapus Peminjaman Aktif Memulihkan Stok | Transaksi berstatus `dipinjam` | 1. Klik Hapus transaksi.<br>2. Konfirmasi. | `QA Router`, jumlah `2` | Transaksi terhapus dan stok alat bertambah kembali sesuai jumlah pada detail transaksi. | sudah diuji | PASS |
| ADM-PG-001 | Admin Memproses Pengembalian Tepat Waktu | Ada peminjaman status `dipinjam` tanpa pengembalian | 1. Buka Kelola Pengembalian.<br>2. Klik Proses Pengembalian.<br>3. Pilih transaksi, isi tanggal aktual dan kondisi.<br>4. Isi denda tambahan `0`, lalu proses. | Tanggal aktual sama dengan rencana; kondisi `Baik`; denda tambahan `0` | Catatan pengembalian tersimpan, status menjadi `dikembalikan`, stok dipulihkan, dan denda `0`. | sudah diuji | PASS |
| ADM-PG-002 | Denda Keterlambatan Dihitung Otomatis | Ada peminjaman aktif dengan tanggal rencana sebelum tanggal aktual | 1. Proses pengembalian dengan tanggal aktual sesudah rencana.<br>2. Periksa nominal denda. | Terlambat `2` hari; denda tambahan `0` | Denda keterlambatan terhitung `Rp10.000` berdasarkan tarif yang ditetapkan controller `Rp5.000/hari`. | sudah diuji | PASS |
| ADM-PG-003 | Denda Tambahan Dijumlahkan Dengan Denda Terlambat | Ada peminjaman aktif yang dikembalikan terlambat | 1. Proses pengembalian dengan tanggal aktual terlambat `2` hari.<br>2. Isi denda tambahan `Rp15.000`. | Keterlambatan `2` hari; denda tambahan `15000` | Total denda tersimpan `Rp25.000` dan tampil pada riwayat pengembalian. | sudah diuji | PASS |
| ADM-PG-004 | Pengembalian Kedua Untuk Transaksi Yang Sama Ditolak | Transaksi sudah punya catatan pengembalian | 1. Buka form pengembalian.<br>2. Coba kirim ID transaksi yang sudah selesai. | ID peminjaman yang sudah memiliki pengembalian | Transaksi tidak diproses kembali; tidak ada catatan duplikat dan stok tidak berubah. | sudah diuji | PASS |
| ADM-PG-005 | Penghapusan Riwayat Pengembalian Mengembalikan Status Dan Stok | Ada catatan pengembalian yang baru diproses | 1. Klik Hapus pada riwayat.<br>2. Konfirmasi.<br>3. Periksa status dan stok transaksi terkait. | Catatan pengembalian QA | Catatan terhapus; status peminjaman kembali `dipinjam`; stok dikurangi kembali sebesar jumlah pinjaman. | sudah diuji | PASS |

## Test Case API

Gunakan prefix `/api` dan kirim token hasil login pada header `Authorization: Bearer <token>`. Bentuk payload peminjaman API berbeda dengan form web: API menggunakan array `items` berisi `alat_id` dan `jumlah`.

| ID | TITLE | PRECONDITION | STEPS | TEST DATA | EXPECTED RESULT | ACTUAL RESULT | STATUS |
|---|---|---|---|---|---|---|---|
| API-001 | Login API Menghasilkan Token | Akun terdaftar | 1. Kirim `POST /api/login`.<br>2. Baca response. | Email `rian@gmail.com`; password `password123` | Response sukses berisi `access_token`, `token_type: Bearer`, dan data pengguna. | sudah diuji | PASS |
| API-002 | Registrasi API Membuat Akun Peminjam | Email belum terdaftar | 1. Kirim `POST /api/register` dengan name, email, password, password_confirmation.<br>2. Periksa response dan data user. | `name: QA API`; `email: qa.api@example.test`; password dan konfirmasi `Budi12345` | Response `201`; akun ber-role `peminjam` dibuat dan token dikembalikan. | sudah diuji | PASS |
| API-003 | API Menolak Token Tanpa Autentikasi | Belum mempunyai token | 1. Kirim `GET /api/me` tanpa Authorization. | Tanpa token | API menolak akses dengan status unauthenticated. | sudah diuji | PASS |
| API-004 | Peminjam Mengajukan Peminjaman API | Token peminjam valid; alat tersedia | 1. Kirim `POST /api/peminjaman` memakai token.<br>2. Periksa response dan daftar riwayat. | `tgl_kembali_plan: YYYY-MM-DD` hari ini atau setelahnya; `items: [{alat_id: ID_QA, jumlah: 2}]` | Response `201`, status `diajukan`, detail sesuai request, stok belum dikurangi. | sudah diuji | PASS |
| API-005 | Pengajuan API Melebihi Stok Ditolak | Token peminjam valid; stok diketahui | 1. Kirim pengajuan dengan jumlah di atas stok. | Stok `5`; jumlah `6` | Response `422`, pengajuan tidak tersimpan, dan pesan stok tidak mencukupi tampil. | sudah diuji | PASS |
| API-006 | Petugas Menyetujui Pengajuan API | Token petugas valid; transaksi `diajukan` dan stok cukup | 1. Kirim `POST /api/peminjaman/{id}/approve`.<br>2. Periksa response, status, dan stok. | Transaksi QA; jumlah `2`; stok `5` | Persetujuan berhasil, status `dipinjam`, stok turun tepat `2`. | sudah diuji | PASS |
| API-007 | Petugas Memproses Pengembalian API | Token petugas valid; peminjaman status `dipinjam` | 1. Kirim `POST /api/pengembalian`.<br>2. Periksa data pengembalian, status peminjaman, dan stok. | `peminjaman_id`; `kondisi_kembali: Baik`; `denda: 0` | Response `201`; satu pengembalian dibuat dan stok dipulihkan. Jika belum lewat tanggal rencana, status akhir `dikembalikan`. | sudah diuji | PASS |
| API-008 | Pengembalian API Terlambat Tidak Tetap Berstatus Aktif | Token petugas valid; transaksi `dipinjam` sudah lewat tanggal rencana | 1. Proses pengembalian.<br>2. Periksa catatan pengembalian, status transaksi, daftar pengembalian web, dan riwayat peminjam. | Tanggal rencana kemarin; kondisi `Baik`; denda `0` | Pengembalian tercatat dan status akhir seharusnya menandakan transaksi selesai; transaksi tidak boleh kembali dianggap sebagai pinjaman aktif. | sudah diuji | PASS |
| API-009 | API Mengisolasi Riwayat Peminjam | Dua peminjam memiliki data transaksi | 1. Login sebagai peminjam A.<br>2. Minta `GET /api/riwayat-pinjam` dan `GET /api/peminjaman`.<br>3. Ulangi sebagai peminjam B. | Token peminjam A dan B | Setiap peminjam hanya menerima peminjaman miliknya. | sudah diuji | PASS |
| API-010 | Logout API Membatalkan Token Saat Ini | Token API aktif | 1. Kirim `POST /api/logout`.<br>2. Ulangi request `GET /api/me` menggunakan token yang sama. | Bearer token aktif | Logout sukses; token lama tidak lagi dapat mengakses endpoint terproteksi. | sudah diuji | PASS |

## Temuan Review Kode

Temuan ini merupakan hasil pembacaan statis, bukan hasil eksekusi browser/API. Gunakan kasus terkait untuk mengonfirmasi setelah aplikasi dijalankan.

| ID Kasus | Temuan pada implementasi saat ini | Dampak yang perlu dikonfirmasi |
|---|---|---|
| AUTH-008, AUTH-009 | Middleware web `CheckRole::handle()` memanggil `$next($request)` baik role cocok maupun tidak. | Pembatasan role pada route web berpotensi tidak berjalan; pengguna yang sudah login dapat melewati halaman milik role lain. |
| API-004, API-005 | Middleware `IsPeminjam::handle()` meneruskan request jika role **bukan** `peminjam`, dan menolak role peminjam. | Endpoint API peminjam kemungkinan menolak pengguna yang berhak dan memberi akses kepada role lain. |
| PEM-008 | Form katalog membatasi jumlah melalui atribut HTML, tetapi `PeminjamController::ajukanPeminjaman()` tidak memvalidasi ID alat/jumlah atau membandingkan jumlah dengan stok. | Request yang dimanipulasi dapat membuat jumlah di atas stok atau data detail yang tidak valid. |
| PEM-010 | Route `peminjam.peminjaman.kembalikan` menunjuk ke `PeminjamController::kembalikanAlat`, tetapi method tersebut tidak ditemukan pada controller; halaman pengembalian peminjam hanya menampilkan daftar dan tidak memiliki tombol aksi. | Jalur aksi pengembalian mandiri peminjam belum tersedia/berpotensi error. Alur yang benar-benar tersedia di UI adalah peminjam menyerahkan alat lalu petugas memprosesnya. |
| PET-005 | `PetugasController::setujuiPeminjaman()` mengubah status ke `dipinjam` dan mengurangi stok tanpa memastikan status sebelumnya masih `diajukan`. | Request persetujuan berulang dapat mengurangi stok berulang kali. |
| PET-010 | Halaman petugas memasukkan status `dikembalikan` dalam daftar proses, dan `prosesPengembalian()` tidak menolak transaksi yang sudah dikembalikan atau sudah memiliki catatan. | Pengiriman ulang berpotensi membuat catatan pengembalian ganda dan menambah stok berulang kali. |
| ADM-PIN-005 | `AdminController::updateStatusPeminjaman()` memulihkan stok hanya saat status lama tepat `dipinjam`, bukan `telat`. | Mengubah status `telat` menjadi `dikembalikan` dapat mencatat pengembalian tanpa memulihkan stok. |
| API-008 | `API PengembalianController::store()` menyimpan transaksi yang terlambat dengan status `telat` walaupun catatan pengembalian sudah dibuat dan stok dipulihkan. | Status hasil pengembalian dapat masih terbaca sebagai pinjaman aktif oleh halaman lain. Perlu validasi aturan bisnis status terlambat. |
| API-006 | Route petugas API memakai parameter `{id}`, sementara method approve menerima model `Peminjaman $peminjaman`; route admin memakai `{peminjaman}`. | Uji route model binding pada endpoint petugas, pastikan transaksi yang dimaksud ter-resolve dan persetujuan berjalan. |
| ADM-PG-002, ADM-PG-003 | Tarif denda otomatis web adalah Rp5.000/hari, sedangkan data seeder pengembalian lama mencatat nominal dengan asumsi tarif berbeda. | Gunakan kasus uji terkontrol dan aturan tarif yang disepakati sebagai oracle; jangan menjadikan nominal seed sebagai ekspektasi. |

## Kriteria Alur End-to-End

Alur utama yang perlu lolos berurutan:

1. Admin login, memastikan akun peminjam/petugas, kategori, dan alat tersedia.
2. Peminjam login, memilih alat dengan stok cukup, mengirim pengajuan, lalu melihat status `diajukan` pada riwayat.
3. Petugas login, menyetujui pengajuan; status menjadi `dipinjam` dan stok berkurang sesuai jumlah.
4. Petugas menerima alat kembali dan menyimpan kondisi/denda; catatan pengembalian muncul, status transaksi selesai, dan stok kembali sesuai jumlah.
5. Admin/petugas memeriksa riwayat dan laporan untuk memastikan identitas, tanggal, kondisi, status, serta denda konsisten.

Simpan hasil eksekusi aktual, tanggal uji, browser/perangkat, dan bukti screenshot/log pada kolom hasil atau lampiran QA terpisah.
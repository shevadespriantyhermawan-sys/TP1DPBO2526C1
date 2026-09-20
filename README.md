# TP1DPBO2526C1

Janji 

Saya Sheva Desprianty Hermawan dengan NIM 2511645 mengerjakan kuis 1 dalam mata kuliah desain pemrograman berorientasi objek untuk keberkahannya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Amin 


# ♭♭ Xdinary Heroes Cinema — Movie Management System

Aplikasi web sederhana berbasis **PHP OOP (Object-Oriented Programming)** untuk mengelola data film bioskop, dilengkapi fitur *upload* gambar poster dari file pribadi dan antarmuka bertema **Xdinary Heroes** (Dark Cyberpunk/Rock).

---

## 🚀 Fitur Utama

- **Tambah Data Film**: Input ID, Judul, Genre, Harga Tiket, serta *upload* poster langsung dari komputer/laptop.
- **Tampil Data Film**: Menampilkan daftar film dalam bentuk tabel rapi beserta foto poster.
- **Edit Data Film**: Mengubah detail film dan memperbarui foto poster (opsional).
- **Hapus Data Film**: Menghapus film tertentu dari daftar.
- **Pencarian Film**: Cari data film berdasarkan ID secara instan.
- **Penyimpanan Session**: Menggunakan `$_SESSION` PHP (tanpa perlu *database* MySQL).
- **Reset Data**: Tombol untuk mengosongkan seluruh isi data tabel.


1. Desain Kelas & Enkapsulasi (Encapsulation Design)Sistem menyembunyikan variabel (attribute) agar tidak bisa diubah sembarangan tanpa melalui metode kontrol (getter/setter).
   +-------------------------------------------------------+
   |                        Film                           |
   +-------------------------------------------------------+
   | - id     : String                                     |
   | - judul  : String                                     |
   | - genre  : String                                     |
   | - harga  : Integer                                    |
   | - gambar : String                                     |
   +-------------------------------------------------------+
   | + Film(id, judul, genre, harga, gambar)               |
   | + getId() : String                                    |
   | + setJudul(judul) : void                              |
   | + ...                                                 |
   +-------------------------------------------------------+
    1. PHP: Menggunakan kata kunci private secara eksplisit. Akses internal wajib memakai $this->. Sifatnya dynamically typed, sehingga tipe data variabel bersifat fleksibel.
    2. Python: Tidak mengenal private access modifier sejati di tingkat sistem. Enkapsulasi dilakukan secara konvensi menggunakan garis bawah ganda (self.__id). Jika diakses dari luar, Python akan melakukan name mangling (_Film__id).
    3. Java: Menerapkan strict typing dan enkapsulasi murni. Setiap atribut secara tegas diatur sebagai private String id;. Akses dari luar wajib melewati metode public getter/setter.
    4. C++: Membagi area kelas secara blok menggunakan label private: dan public:. Penanganan memori atribut string/integer dikelola langsung dalam struktur objek di stack atau heap.

2. Desain Manajemen Memori & Status (State Management)Bagaimana aplikasi menyimpan daftar film di RAM atau penyimpanan lokal saat program berjalan.

  [ Client / Browser ]
                │
                ▼
  ┌───────────────────────────┐
  │      PHP Environment      │ ──► Sifatnya Stateless!
  └─────────────┬─────────────┘     Tiap refresh RAM bersih.
                │                   Membutuhkan $_SESSION (Disk/File).
                ▼
  ┌───────────────────────────┐
  │  Python / Java / C++ App  │ ──► Sifatnya Stateful (Persistent in RAM)!
  └─────────────┬─────────────┘     Data hidup di memori selama
                │                   proses aplikasi berjalan.
                ▼
     [ Wadah Data / Memory ]

    1. PHP: Sifat eksekusi PHP adalah stateless (mati setiap kali request HTTP selesai). Karena itu, desain penyimpanan film harus bergantung pada $_SESSION. Data objek di-serialize otomatis oleh PHP dan disimpan dalam berkas sementara di server.
    2. Python: Menyimpan daftar objek dalam wadah list dinamis (berbasis PyObject* di bahasa C penyusun Python). Dalam aplikasi desktop/CLI, data tetap hidup di RAM sampai aplikasi ditutup.
    3. Java: Menggunakan ArrayList<Film>. ArrayList membungkus array objek di area memori Heap. Jika kapasitas penuh, Java otomatis membuat array baru yang lebih besar (biasanya berkali lipat dari ukuran awal) dan memindahkan referensinya.
    4. C++: Menggunakan std::vector<Film>. Vector menaruh elemen secara berurutan (contiguous memory) di Heap. Desain ini menghasilkan performa pembacaan paling cepat dibanding bahasa lain karena memanfaatkan CPU Cache Line.

3. Desain Logika Algoritma CRUDA. 
A. Tambah Data (Create)

    1. PHP: $_SESSION['list_film'][] = $film; (Menambahkan ke indeks array berikutnya).
    2. Python: list_film.append(film) (Menambahkan referensi objek ke bagian akhir list).
    3. Java: listFilm.add(film) (Menyimpan pointer referensi objek ke memori Heap ArrayList).
    4. C++: listFilm.push_back(film) (Membuat salinan objek atau memindahkan instansi menggunakan move semantics ke dalam vector).

B. Edit Data (Update)Saat mengedit data di dalam perulangan (looping), perbedaan cara penanganan variabel (referensi vs nilai) sangat krusial:

[Mulai Loop Cari ID] ──► Apakah ID Cocok?
                             │
            ┌────────────────┴────────────────┐
            ▼                                 ▼
      [Bahasa Reference]              [C++ Value Copy]
 (PHP Obj, Python, Java)                 (Perlu &)
            │                                 │
   Mengubah properti         Wajib gunakan pass-by-reference:
   langsung berdampak        `for (Film &f : listFilm)`
   pada objek di RAM.        Agar perubahan tidak hilang.

    1. PHP, Python, & Java: Secara standar memperlakukan variabel objek sebagai reference (alamat memori). Ketika memanggil obj.setJudul("Baru") di dalam looping, data di dalam daftar utama otomatis ikut berubah.

    2. C++: Secara standar menerapkan pass-by-value (membuat salinan baru saat looping). Agar data di dalam std::vector benar-benar ter-update, looping harus secara eksplisit menggunakan reference (&):

C. Hapus Data (Delete)

    1. PHP: unset($list[$i]) menghapus elemen, tetapi meninggalkan ruang kosong pada indeks (misal indeks 1 hilang, tersisa 0 dan 2). Karena itu butuh array_values() untuk menata ulang indeks dari 0.
    2. Python: list_film.pop(i) atau del list_film[i] langsung menghapus dan menggeser posisi indeks di belakangnya.
    3. Java: listFilm.remove(i) menghapus objek dan melakukan pergeseran elemen (element shift) secara otomatis pada array internalnya.
    4. C++: listFilm.erase(listFilm.begin() + i) menghapus elemen via iterator dan menggeser seluruh blok memori di sebelahnya.

4. Desain Penanganan Berkas (Upload/IO Poster)

    1. PHP
    Komponen utama: $_FILES, move_uploaded_file()
    Mekanisme: Server web (seperti Apache) secara otomatis menangani stream multipart/form-data dan menampungnya di folder sementara (tmp). PHP bertugas memindahkan berkas fisik tersebut dari folder sementara ke lokasi direktori tujuan.

    2. Python
    Komponen utama: open(), shutil, atau pustaka bawaan dari framework web (Flask/Django)
    Mekanisme: Membaca data stream biner dari request yang masuk, lalu menuliskannya langsung menjadi berkas baru di sistem lokal menggunakan blok with open(path, "wb") as f.

    3. Java
    Komponen utama: java.nio.file.Files, InputStream
    Mekanisme: Membaca input stream data dari sumber berkas, kemudian menggunakan metode Files.copy(stream, targetPath, StandardCopyOption.REPLACE_EXISTING) untuk menyalin aliran byte tersebut ke berkas tujuan.

    4. C++
    Komponen utama: std::ifstream, std::ofstream, atau std::filesystem (C++17+)
    Mekanisme: Membuka saluran berkas biner (binary stream), membaca blok byte dari berkas sumber ke dalam buffer memori, lalu menuliskan isi buffer tersebut ke berkas tujuan di sistem lokal (atau langsung menyalin berkas dengan perintah std::filesystem::copy).
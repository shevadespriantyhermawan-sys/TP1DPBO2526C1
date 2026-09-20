from film import Film


# Fungsi pembantu untuk mencetak garis pembatas
def cetak_garis():
    print(
        "+--------+---------------------------+---------------+--------------+"
    )


# Fungsi pembantu untuk mencetak header tabel
def cetak_header():
    cetak_garis()
    print(
        f"| {'ID':<6} | {'Judul Film':<25} | {'Genre':<13} | {'Harga Tiket':<12} |"
    )
    cetak_garis()


# Fungsi pembantu untuk mencetak baris data film
def cetak_baris(film):
    print(
        f"| {film.get_id():<6} | {film.get_judul():<25} | {film.get_genre():<13} | Rp {film.get_harga():<9} |"
    )


# Fungsi pencarian indeks berdasarkan ID film (Return -1 jika tidak ditemukan)
def cari_index(list_film, id_film):
    for i, film in enumerate(list_film):
        if film.get_id().lower() == id_film.lower():
            return i
    return -1


def main():
    # Inisialisasi 14 Data Film Awal
    list_film = [
        Film("F01", "Avengers: Endgame", "Action", 50000),
        Film("F02", "Iron Man", "Action", 45000),
        Film("F03", "Elemental", "Animation", 40000),
        Film("F04", "Coco", "Animation", 40000),
        Film("F05", "Interstellar", "Sci-Fi", 55000),
        Film("F06", "Avatar", "Sci-Fi", 50000),
        Film("F07", "Transformers", "Action", 45000),
        Film("F08", "Along with the Gods", "Fantasy", 45000),
        Film("F09", "Toy Story", "Animation", 35000),
        Film("F10", "Zootopia", "Animation", 40000),
        Film("F11", "Mortal Kombat", "Action", 45000),
        Film("F12", "Cinderella", "Fantasy", 35000),
        Film("F13", "Frozen 3", "Animation", 45000),
        Film("F14", "Ratatouille", "Animation", 35000),
    ]

    # Loop menu program
    while True:
        print(
            "\n================================================================="
        )
        print(
            "                 MENU MANAGEMENT BIOSKOP (PYTHON)               "
        )
        print(
            "================================================================="
        )
        print("1. Tambah Data Film")
        print("2. Tampilkan Semua Film")
        print("3. Update Data Film")
        print("4. Hapus Data Film")
        print("5. Cari Data Film")
        print("6. Keluar")
        pilihan = input("Pilih menu (1-6): ")

        # Menu 1: Tambah Data Film
        if pilihan == "1":
            print("\n[ TAMBAH DATA FILM ]")
            id_film = input("Masukkan ID Film    : ")
            judul = input("Masukkan Judul      : ")
            genre = input("Masukkan Genre      : ")
            harga = int(input("Masukkan Harga Tiket: "))
            list_film.append(Film(id_film, judul, genre, harga))
            print(">> Data film berhasil ditambahkan!")

        # Menu 2: Tampilkan Semua Film
        elif pilihan == "2":
            if not list_film:
                print("Belum ada data film.")
            else:
                print("\n                     DAFTAR FILM BIOSKOP")
                cetak_header()
                for film in list_film:
                    cetak_baris(film)
                cetak_garis()

        # Menu 3: Update Data Film
        elif pilihan == "3":
            print("\n[ UPDATE DATA FILM ]")
            id_film = input("Masukkan ID Film yang ingin di-update: ")
            idx = cari_index(list_film, id_film)
            if idx != -1:
                judul_baru = input("Judul Baru      : ")
                genre_baru = input("Genre Baru      : ")
                harga_baru = int(input("Harga Baru      : "))

                list_film[idx].set_judul(judul_baru)
                list_film[idx].set_genre(genre_baru)
                list_film[idx].set_harga(harga_baru)
                print(">> Data film berhasil di-update!")
            else:
                print(f">> Error: Film dengan ID '{id_film}' tidak ditemukan.")

        # Menu 4: Hapus Data Film
        elif pilihan == "4":
            print("\n[ HAPUS DATA FILM ]")
            id_film = input("Masukkan ID Film yang ingin dihapus: ")
            idx = cari_index(list_film, id_film)
            if idx != -1:
                list_film.pop(idx)
                print(">> Data film berhasil dihapus!")
            else:
                print(f">> Error: Film dengan ID '{id_film}' tidak ditemukan.")

        # Menu 5: Cari Data Film
        elif pilihan == "5":
            print("\n[ CARI DATA FILM ]")
            id_film = input("Masukkan ID Film yang dicari: ")
            idx = cari_index(list_film, id_film)
            if idx != -1:
                print("\n                       HASIL PENCARIAN")
                cetak_header()
                cetak_baris(list_film[idx])
                cetak_garis()
            else:
                print(f">> Error: Film dengan ID '{id_film}' tidak ditemukan.")

        # Menu 6: Keluar
        elif pilihan == "6":
            print("\nTerima kasih telah menggunakan sistem bioskop.")
            break


if __name__ == "__main__":
    main()
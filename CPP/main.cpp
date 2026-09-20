#include <iostream>
#include <vector>
#include <iomanip>
#include "Film.cpp"

using namespace std;

// Fungsi pembantu untuk mencetak garis pembatas tabel
void cetakGaris() {
    cout << "+--------+---------------------------+---------------+--------------+\n";
}

// Fungsi pembantu untuk mencetak header tabel
void cetakHeaderTabel() {
    cetakGaris();
    cout << "| " << left << setw(6) << "ID"
         << " | " << setw(25) << "Judul Film"
         << " | " << setw(13) << "Genre"
         << " | " << setw(12) << "Harga Tiket" << " |\n";
    cetakGaris();
}

// Fungsi pembantu untuk mencetak satu baris data film
void cetakBaris(const Film& f) {
    cout << "| " << left << setw(6) << f.getId()
         << " | " << setw(25) << f.getJudul()
         << " | " << setw(13) << f.getGenre()
         << " | Rp " << left << setw(9) << f.getHarga() << " |\n";
}

// Fungsi linear search untuk mencari indeks film berdasarkan ID (Return -1 jika tidak ketemu)
int cariIndex(const vector<Film>& listFilm, const string& id) {
    for (size_t i = 0; i < listFilm.size(); i++) {
        if (listFilm[i].getId() == id) return i;
    }
    return -1;
}

int main() {
    // Inisialisasi 14 data film awal ke dalam vector
    vector<Film> listFilm = {
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
        Film("F14", "Ratatouille", "Animation", 35000)
    };

    int pilihan;
    do {
        // Tampilan menu utama
        cout << "\n=================================================================\n"
             << "                 MENU MANAGEMENT BIOSKOP (C++)                  \n"
             << "=================================================================\n"
             << "1. Tambah Data Film\n"
             << "2. Tampilkan Semua Film\n"
             << "3. Update Data Film\n"
             << "4. Hapus Data Film\n"
             << "5. Cari Data Film\n"
             << "6. Keluar\n"
             << "Pilih menu (1-6): ";
        cin >> pilihan;
        cin.ignore(); // Membersihkan newline dari buffer input

        // Menu 1: Tambah Data Film
        if (pilihan == 1) {
            string id, judul, genre;
            int harga;
            cout << "\n[ TAMBAH DATA FILM ]\n";
            cout << "Masukkan ID Film    : "; getline(cin, id);
            cout << "Masukkan Judul      : "; getline(cin, judul);
            cout << "Masukkan Genre      : "; getline(cin, genre);
            cout << "Masukkan Harga Tiket: "; cin >> harga; cin.ignore();

            listFilm.push_back(Film(id, judul, genre, harga));
            cout << ">> Data film berhasil ditambahkan!\n";

        // Menu 2: Tampilkan Semua Film
        } else if (pilihan == 2) {
            if (listFilm.empty()) {
                cout << "Belum ada data film.\n";
            } else {
                cout << "\n                     DAFTAR FILM BIOSKOP\n";
                cetakHeaderTabel();
                for (const auto& f : listFilm) {
                    cetakBaris(f);
                }
                cetakGaris();
            }

        // Menu 3: Update Data Film
        } else if (pilihan == 3) {
            string id, judul, genre;
            int harga;
            cout << "\n[ UPDATE DATA FILM ]\n";
            cout << "Masukkan ID Film yang ingin di-update: "; getline(cin, id);
            int idx = cariIndex(listFilm, id);
            if (idx != -1) {
                cout << "Judul Baru      : "; getline(cin, judul);
                cout << "Genre Baru      : "; getline(cin, genre);
                cout << "Harga Baru      : "; cin >> harga; cin.ignore();
                
                listFilm[idx].setJudul(judul);
                listFilm[idx].setGenre(genre);
                listFilm[idx].setHarga(harga);
                cout << ">> Data film berhasil di-update!\n";
            } else {
                cout << ">> Error: Film dengan ID '" << id << "' tidak ditemukan.\n";
            }

        // Menu 4: Hapus Data Film
        } else if (pilihan == 4) {
            string id;
            cout << "\n[ HAPUS DATA FILM ]\n";
            cout << "Masukkan ID Film yang ingin dihapus: "; getline(cin, id);
            int idx = cariIndex(listFilm, id);
            if (idx != -1) {
                listFilm.erase(listFilm.begin() + idx);
                cout << ">> Data film berhasil dihapus!\n";
            } else {
                cout << ">> Error: Film dengan ID '" << id << "' tidak ditemukan.\n";
            }

        // Menu 5: Cari Data Film
        } else if (pilihan == 5) {
            string id;
            cout << "\n[ CARI DATA FILM ]\n";
            cout << "Masukkan ID Film yang dicari: "; getline(cin, id);
            int idx = cariIndex(listFilm, id);
            if (idx != -1) {
                cout << "\n                       HASIL PENCARIAN\n";
                cetakHeaderTabel();
                cetakBaris(listFilm[idx]);
                cetakGaris();
            } else {
                cout << ">> Error: Film dengan ID '" << id << "' tidak ditemukan.\n";
            }
        }
    } while (pilihan != 6);

    cout << "\nTerima kasih telah menggunakan sistem bioskop.\n";
    return 0;
}
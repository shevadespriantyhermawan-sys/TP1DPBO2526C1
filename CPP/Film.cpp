#ifndef FILM_H
#define FILM_H

#include <string>

using namespace std;

// Class model untuk menyimpan data dasar suatu film
class Film {
private:
    // Atribut privat (Enkapsulasi)
    string id;
    string judul;
    string genre;
    int harga;

public:
    // Constructor untuk inisialisasi objek Film
    Film(string id, string judul, string genre, int harga) {
        this->id = id;
        this->judul = judul;
        this->genre = genre;
        this->harga = harga;
    }

    // Getter untuk mengambil nilai atribut
    string getId() const { return id; }
    string getJudul() const { return judul; }
    string getGenre() const { return genre; }
    int getHarga() const { return harga; }

    // Setter untuk mengubah nilai atribut
    void setJudul(string j) { judul = j; }
    void setGenre(string g) { genre = g; }
    void setHarga(int h) { harga = h; }
};

#endif
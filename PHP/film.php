<?php
// Class model untuk menyimpan struktur data objek film
class Film {
    private $id;
    private $judul;
    private $genre;
    private $harga;
    private $gambar; // Nama file gambar (misal: poster.jpg)

    public function __construct($id, $judul, $genre, $harga, $gambar) {
        $this->id = $id;
        $this->judul = $judul;
        $this->genre = $genre;
        $this->harga = $harga;
        $this->gambar = $gambar;
    }

    // Getter
    public function getId() { return $this->id; }
    public function getJudul() { return $this->judul; }
    public function getGenre() { return $this->genre; }
    public function getHarga() { return $this->harga; }
    public function getGambar() { return $this->gambar; }

    // Setter
    public function setJudul($judul) { $this->judul = $judul; }
    public function setGenre($genre) { $this->genre = $genre; }
    public function setHarga($harga) { $this->harga = $harga; }
    public function setGambar($gambar) { $this->gambar = $gambar; }
}
?>
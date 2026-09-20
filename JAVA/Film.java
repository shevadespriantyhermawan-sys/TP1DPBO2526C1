// Class model untuk menyimpan data dasar suatu film
public class Film {
    // Atribut privat (Enkapsulasi)
    private String id;
    private String judul;
    private String genre;
    private int harga;

    // Constructor untuk membuat objek Film baru
    public Film(String id, String judul, String genre, int harga) {
        this.id = id;
        this.judul = judul;
        this.genre = genre;
        this.harga = harga;
    }

    // Getter untuk mengambil nilai atribut
    public String getId() { return id; }
    public String getJudul() { return judul; }
    public String getGenre() { return genre; }
    public int getHarga() { return harga; }

    // Setter untuk mengubah nilai atribut
    public void setJudul(String judul) { this.judul = judul; }
    public void setGenre(String genre) { this.genre = genre; }
    public void setHarga(int harga) { this.harga = harga; }
}
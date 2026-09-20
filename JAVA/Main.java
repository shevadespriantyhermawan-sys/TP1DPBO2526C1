import java.util.ArrayList;
import java.util.Scanner;

public class Main {
    // Method pembantu untuk mencetak garis pembatas
    private static void cetakGaris() {
        System.out.println("+--------+---------------------------+---------------+--------------+");
    }

    // Method pembantu untuk mencetak header tabel
    private static void cetakHeader() {
        cetakGaris();
        System.out.printf("| %-6s | %-25s | %-13s | %-12s |\n", "ID", "Judul Film", "Genre", "Harga Tiket");
        cetakGaris();
    }

    // Method pembantu untuk mencetak satu baris data film
    private static void cetakBaris(Film f) {
        System.out.printf("| %-6s | %-25s | %-13s | Rp %-9d |\n",
                f.getId(), f.getJudul(), f.getGenre(), f.getHarga());
    }

    // Method pencarian indeks berdasarkan ID film (Return -1 jika tidak ditemukan)
    private static int cariIndex(ArrayList<Film> listFilm, String id) {
        for (int i = 0; i < listFilm.size(); i++) {
            if (listFilm.get(i).getId().equalsIgnoreCase(id)) return i;
        }
        return -1;
    }

    public static void main(String[] args) {
        ArrayList<Film> listFilm = new ArrayList<>();

        // Inisialisasi 14 data film awal
        listFilm.add(new Film("F01", "Avengers: Endgame", "Action", 50000));
        listFilm.add(new Film("F02", "Iron Man", "Action", 45000));
        listFilm.add(new Film("F03", "Elemental", "Animation", 40000));
        listFilm.add(new Film("F04", "Coco", "Animation", 40000));
        listFilm.add(new Film("F05", "Interstellar", "Sci-Fi", 55000));
        listFilm.add(new Film("F06", "Avatar", "Sci-Fi", 50000));
        listFilm.add(new Film("F07", "Transformers", "Action", 45000));
        listFilm.add(new Film("F08", "Along with the Gods", "Fantasy", 45000));
        listFilm.add(new Film("F09", "Toy Story", "Animation", 35000));
        listFilm.add(new Film("F10", "Zootopia", "Animation", 40000));
        listFilm.add(new Film("F11", "Mortal Kombat", "Action", 45000));
        listFilm.add(new Film("F12", "Cinderella", "Fantasy", 35000));
        listFilm.add(new Film("F13", "Frozen 3", "Animation", 45000));
        listFilm.add(new Film("F14", "Ratatouille", "Animation", 35000));

        Scanner scanner = new Scanner(System.in);
        int pilihan = 0;

        // Loop menu program
        do {
            System.out.println("\n=================================================================");
            System.out.println("                 MENU MANAGEMENT BIOSKOP (JAVA)                 ");
            System.out.println("=================================================================");
            System.out.println("1. Tambah Data Film");
            System.out.println("2. Tampilkan Semua Film");
            System.out.println("3. Update Data Film");
            System.out.println("4. Hapus Data Film");
            System.out.println("5. Cari Data Film");
            System.out.println("6. Keluar");
            System.out.print("Pilih menu (1-6): ");
            pilihan = scanner.nextInt();
            scanner.nextLine(); // Membersihkan sisa newline di buffer

            switch (pilihan) {
                case 1:
                    // Tambah Data Film
                    System.out.println("\n[ TAMBAH DATA FILM ]");
                    System.out.print("Masukkan ID Film    : "); String id = scanner.nextLine();
                    System.out.print("Masukkan Judul      : "); String judul = scanner.nextLine();
                    System.out.print("Masukkan Genre      : "); String genre = scanner.nextLine();
                    System.out.print("Masukkan Harga Tiket: "); int harga = scanner.nextInt(); scanner.nextLine();
                    listFilm.add(new Film(id, judul, genre, harga));
                    System.out.println(">> Data film berhasil ditambahkan!");
                    break;

                case 2:
                    // Tampilkan Semua Film
                    if (listFilm.isEmpty()) {
                        System.out.println("Belum ada data film.");
                    } else {
                        System.out.println("\n                     DAFTAR FILM BIOSKOP");
                        cetakHeader();
                        for (Film f : listFilm) {
                            cetakBaris(f);
                        }
                        cetakGaris();
                    }
                    break;

                case 3:
                    // Update Data Film
                    System.out.println("\n[ UPDATE DATA FILM ]");
                    System.out.print("Masukkan ID Film yang ingin di-update: "); String updateId = scanner.nextLine();
                    int idxUpdate = cariIndex(listFilm, updateId);
                    if (idxUpdate != -1) {
                        System.out.print("Judul Baru      : "); String judulBaru = scanner.nextLine();
                        System.out.print("Genre Baru      : "); String genreBaru = scanner.nextLine();
                        System.out.print("Harga Baru      : "); int hargaBaru = scanner.nextInt(); scanner.nextLine();
                        
                        listFilm.get(idxUpdate).setJudul(judulBaru);
                        listFilm.get(idxUpdate).setGenre(genreBaru);
                        listFilm.get(idxUpdate).setHarga(hargaBaru);
                        System.out.println(">> Data film berhasil di-update!");
                    } else {
                        System.out.println(">> Error: Film dengan ID '" + updateId + "' tidak ditemukan.");
                    }
                    break;

                case 4:
                    // Hapus Data Film
                    System.out.println("\n[ HAPUS DATA FILM ]");
                    System.out.print("Masukkan ID Film yang ingin dihapus: "); String deleteId = scanner.nextLine();
                    int idxDelete = cariIndex(listFilm, deleteId);
                    if (idxDelete != -1) {
                        listFilm.remove(idxDelete);
                        System.out.println(">> Data film berhasil dihapus!");
                    } else {
                        System.out.println(">> Error: Film dengan ID '" + deleteId + "' tidak ditemukan.");
                    }
                    break;

                case 5:
                    // Cari Data Film
                    System.out.println("\n[ CARI DATA FILM ]");
                    System.out.print("Masukkan ID Film yang dicari: "); String searchId = scanner.nextLine();
                    int idxSearch = cariIndex(listFilm, searchId);
                    if (idxSearch != -1) {
                        System.out.println("\n                       HASIL PENCARIAN");
                        cetakHeader();
                        cetakBaris(listFilm.get(idxSearch));
                        cetakGaris();
                    } else {
                        System.out.println(">> Error: Film dengan ID '" + searchId + "' tidak ditemukan.");
                    }
                    break;
            }
        } while (pilihan != 6);

        System.out.println("\nTerima kasih telah menggunakan sistem bioskop.");
        scanner.close();
    }
}
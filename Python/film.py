class Film:
    """Class Model Film untuk menyimpan data objek film."""

    def __init__(self, id_film, judul, genre, harga):
        # Atribut private menggunakan prefix dunder (__), bentuk enkapsulasi
        self.__id = id_film
        self.__judul = judul
        self.__genre = genre
        self.__harga = harga

    # --- Getters ---
    def get_id(self):
        return self.__id

    def get_judul(self):
        return self.__judul

    def get_genre(self):
        return self.__genre

    def get_harga(self):
        return self.__harga

    # --- Setters ---
    def set_judul(self, judul):
        self.__judul = judul

    def set_genre(self, genre):
        self.__genre = genre

    def set_harga(self, harga):
        self.__harga = harga
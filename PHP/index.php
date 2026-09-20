<?php

// WAJIB: Import film.php sebelum session_start() agar tidak terjadi error incomplete object
require_once 'film.php';
session_start();

// Buat folder uploads jika belum ada untuk keamanan berkas
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Inisialisasi data awal jika session belum ada
if (!isset($_SESSION['list_film']) || empty($_SESSION['list_film'])) {
    $_SESSION['list_film'] = [
        new Film("F01", "Avengers: Endgame", "Action", 50000, "endgame.jpg"),
        new Film("F02", "Iron Man", "Action", 45000, "ironman.jpg"),
        new Film("F03", "Elemental", "Animation", 40000, "elemental.jpg"),
        new Film("F04", "Coco", "Animation", 40000, "coco.jpg"),
        new Film("F05", "Interstellar", "Sci-Fi", 55000, "interstellar.jpg"),
        new Film("F06", "Avatar", "Sci-Fi", 50000, "avatar.jpg"),
        new Film("F07", "Transformers", "Action", 45000, "transformers.jpg"),
        new Film("F08", "Along with the Gods", "Fantasy", 45000, "alongwiththegods.jpg"),
        new Film("F09", "Toy Story", "Animation", 35000, "toystory.jpg"),
        new Film("F10", "Zootopia", "Animation", 40000, "zootopia.jpg"),
        new Film("F11", "Mortal Kombat", "Action", 45000, "mortalkombat.jpg"),
        new Film("F12", "Cinderella", "Fantasy", 35000, "cinderella.jpg"),
        new Film("F13", "Frozen 3", "Animation", 45000, "frozen3.jpg"),
        new Film("F14", "Ratatouille", "Animation", 35000, "ratatouille.jpg")
    ];
}

// Reset data ke kondisi default
if (isset($_GET['reset'])) {
    unset($_SESSION['list_film']);
    session_write_close();
    header("Location: index.php");
    exit();
}

// Fitur 1: Tambah Data Film + Upload Foto Pribadi
if (isset($_POST['tambah'])) {
    $id = trim($_POST['id']);
    $judul = trim($_POST['judul']);
    $genre = trim($_POST['genre']);
    $harga = (int)$_POST['harga'];
    
    $namaGambar = "default.jpg";
    
    // Proses Upload File Foto dari Komputer secara Aman
    if (isset($_FILES['gambar_file']) && $_FILES['gambar_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['gambar_file']['tmp_name'];
        $fileName = basename($_FILES['gambar_file']['name']);
        
        // Buat nama file unik agar tidak saling menimpa
        $cleanFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
        $namaGambarUnik = time() . '_' . $cleanFileName;
        $destPath = $uploadDir . $namaGambarUnik;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $namaGambar = $destPath;
        }
    }

    $_SESSION['list_film'][] = new Film($id, $judul, $genre, $harga, $namaGambar);
    session_write_close();
    header("Location: index.php");
    exit();
}

// Fitur 4: Hapus Data Film
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    foreach ($_SESSION['list_film'] as $key => $film) {
        if ($film->getId() == $id) {
            unset($_SESSION['list_film'][$key]);
            $_SESSION['list_film'] = array_values($_SESSION['list_film']);
            break;
        }
    }
    session_write_close();
    header("Location: index.php");
    exit();
}

// Persiapan Edit Data
$editFilm = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    foreach ($_SESSION['list_film'] as $film) {
        if ($film->getId() == $id) {
            $editFilm = $film;
            break;
        }
    }
}

// Fitur 3: Update Data Film + Opsional Ganti Foto
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    foreach ($_SESSION['list_film'] as $key => $film) {
        if ($film->getId() == $id) {
            $_SESSION['list_film'][$key]->setJudul(trim($_POST['judul']));
            $_SESSION['list_film'][$key]->setGenre(trim($_POST['genre']));
            $_SESSION['list_film'][$key]->setHarga((int)$_POST['harga']);
            
            // Jika memilih file foto baru saat edit
            if (isset($_FILES['gambar_file']) && $_FILES['gambar_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['gambar_file']['tmp_name'];
                $fileName = basename($_FILES['gambar_file']['name']);
                
                $cleanFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
                $namaGambarBaru = $uploadDir . time() . '_' . $cleanFileName;
                
                if (move_uploaded_file($fileTmpPath, $namaGambarBaru)) {
                    $_SESSION['list_film'][$key]->setGambar($namaGambarBaru);
                }
            }
            break;
        }
    }
    session_write_close();
    header("Location: index.php");
    exit();
}

// Fitur 5: Cari Data Film
$hasilCari = null;
if (isset($_GET['cari'])) {
    $keyword = trim($_GET['keyword']);
    foreach ($_SESSION['list_film'] as $film) {
        if (strtolower($film->getId()) == strtolower($keyword)) {
            $hasilCari = $film;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XDINARY HEROES - Cinema Management</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&family=Rajdhani:wght@500;700&display=swap');

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: #08080c;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #10121a;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #ff0055;
            box-shadow: 0 0 20px rgba(255, 0, 85, 0.25), 0 0 40px rgba(0, 240, 255, 0.15);
        }

        .header-title {
            text-align: center;
            font-family: 'Orbitron', sans-serif;
            color: #ff0055;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 5px;
            text-shadow: 0 0 10px #ff0055, 0 0 20px #ff0055;
        }

        .sub-title {
            text-align: center;
            color: #00f0ff;
            font-size: 14px;
            letter-spacing: 2px;
            margin-bottom: 25px;
            text-shadow: 0 0 8px #00f0ff;
        }

        .grid-container {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-box {
            flex: 1;
            background: #171a26;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #2a2f45;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
        }

        .form-box h3 {
            margin-top: 0;
            font-family: 'Orbitron', sans-serif;
            font-size: 16px;
            color: #00f0ff;
            border-bottom: 2px solid #ff0055;
            padding-bottom: 8px;
            text-shadow: 0 0 5px #00f0ff;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #b3b9c9;
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 6px 0 12px 0;
            background-color: #0a0b10;
            border: 1px solid #00f0ff;
            border-radius: 4px;
            color: #fff;
            box-sizing: border-box;
            font-family: 'Rajdhani', sans-serif;
        }

        input[type="file"] {
            padding: 5px;
            background: #10121a;
            border: 1px dashed #ff0055;
            cursor: pointer;
        }

        button {
            background: linear-gradient(45deg, #ff0055, #b026ff);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
            box-shadow: 0 0 10px rgba(255, 0, 85, 0.5);
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(255, 0, 85, 0.8);
        }

        .btn-cancel {
            background: #333;
            text-decoration: none;
            color: #ccc;
            padding: 9px 14px;
            border-radius: 4px;
            font-size: 13px;
            margin-left: 5px;
            display: inline-block;
        }

        .btn-reset {
            background: linear-gradient(45deg, #00f0ff, #0072ff);
            text-decoration: none;
            color: #000;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-family: 'Orbitron', sans-serif;
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.4);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #171a26;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #2a2f45;
            padding: 12px;
            text-align: left;
            font-size: 15px;
        }

        th {
            background: #0a0b10;
            color: #ff0055;
            font-family: 'Orbitron', sans-serif;
            font-size: 13px;
            letter-spacing: 1px;
        }

        tr:nth-child(even) { background-color: #12141d; }
        tr:hover { background-color: #1f2436; }

        .img-preview {
            width: 55px;
            height: 75px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #00f0ff;
            box-shadow: 0 0 8px rgba(0, 240, 255, 0.3);
        }

        .action-link {
            color: #00f0ff;
            text-decoration: none;
            font-weight: bold;
        }

        .action-delete {
            color: #ff0055;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .alert {
            padding: 12px;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 12px;
        }

        .alert-success {
            background-color: rgba(0, 240, 255, 0.1);
            color: #00f0ff;
            border: 1px solid #00f0ff;
        }

        .alert-danger {
            background-color: rgba(255, 0, 85, 0.1);
            color: #ff0055;
            border: 1px solid #ff0055;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="header-title">♭♭ XDINARY HEROES CINEMA ♭♭</h1>
    <div class="sub-title">WE ARE ALL HEROES - MOVIE MANAGEMENT SYSTEM</div>

    <div class="grid-container">
        <!-- Form Input / Update Data Film -->
        <div class="form-box">
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <h3><?= $editFilm ? 'EDIT DATA FILM' : 'TAMBAH FILM BARU' ?></h3>
                
                <?php if (!$editFilm): ?>
                    <label>ID Film:</label>
                    <input type="text" name="id" placeholder="Contoh: F15" required>
                <?php else: ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editFilm->getId()) ?>">
                    <p><strong>ID Film:</strong> <span style="color: #00f0ff;"><?= htmlspecialchars($editFilm->getId()) ?></span></p>
                <?php endif; ?>

                <label>Judul Film:</label>
                <input type="text" name="judul" value="<?= $editFilm ? htmlspecialchars($editFilm->getJudul()) : '' ?>" required>

                <label>Genre:</label>
                <input type="text" name="genre" value="<?= $editFilm ? htmlspecialchars($editFilm->getGenre()) : '' ?>" required>

                <label>Harga Tiket (Rp):</label>
                <input type="number" name="harga" value="<?= $editFilm ? htmlspecialchars($editFilm->getHarga()) : '' ?>" required>

                <label>Upload Foto Poster (Dari File Pribadi):</label>
                <input type="file" name="gambar_file" accept="image/*" <?= $editFilm ? '' : 'required' ?>>
                <?php if ($editFilm): ?>
                    <small style="color:#aaa; display:block; margin-top:-8px; margin-bottom:10px;">*Biarkan kosong jika tidak ingin mengubah foto saat ini (<?= htmlspecialchars($editFilm->getGambar()) ?>).</small>
                <?php endif; ?>

                <?php if ($editFilm): ?>
                    <button type="submit" name="update">SIMPAN PERUBAHAN</button>
                    <a href="index.php" class="btn-cancel">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah">TAMBAH FILM</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Form Pencarian Data Film -->
        <div class="form-box">
            <form action="index.php" method="GET">
                <h3>CARI DATA FILM</h3>
                <label>Masukkan ID Film:</label>
                <input type="text" name="keyword" placeholder="Contoh: F01" required>
                <button type="submit" name="cari" style="background: linear-gradient(45deg, #00f0ff, #0072ff);">CARI</button>
                <a href="index.php" class="btn-cancel">Reset Cari</a>
            </form>

            <?php if (isset($_GET['cari'])): ?>
                <?php if ($hasilCari): ?>
                    <div class="alert alert-success">
                        <strong>DATA DITEMUKAN!</strong><br>
                        ID: <?= htmlspecialchars($hasilCari->getId()) ?><br>
                        Judul: <?= htmlspecialchars($hasilCari->getJudul()) ?><br>
                        Genre: <?= htmlspecialchars($hasilCari->getGenre()) ?><br>
                        Harga: Rp <?= number_format($hasilCari->getHarga(), 0, ',', '.') ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        Film dengan ID <strong>"<?= htmlspecialchars($_GET['keyword']) ?>"</strong> tidak ditemukan.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabel Daftar Film -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h3 style="margin: 0; font-family: 'Orbitron', sans-serif; color: #ff0055;">DAFTAR FILM TERDAFTAR</h3>
        <a href="index.php?reset=1" class="btn-reset" onclick="return confirm('Kembalikan ke data awal?')">RESET DEFAULT DATA</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th style="text-align: center;">Gambar</th>
                <th>Judul Film</th>
                <th>Genre</th>
                <th>Harga Tiket</th>
                <th>Lokasi / Nama File Gambar</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($_SESSION['list_film'])): ?>
                <tr><td colspan="7" style="text-align:center;">Tidak ada data film.</td></tr>
            <?php else: ?>
                <?php foreach ($_SESSION['list_film'] as $film): ?>
                    <tr>
                        <td><strong style="color: #00f0ff;"><?= htmlspecialchars($film->getId()) ?></strong></td>
                        <td style="text-align: center;">
                            <img src="<?= htmlspecialchars($film->getGambar()) ?>" alt="Poster" class="img-preview" onerror="this.src='https://via.placeholder.com/55x75/10121a/ff0055?text=No+Poster'">
                        </td>
                        <td><strong><?= htmlspecialchars($film->getJudul()) ?></strong></td>
                        <td><?= htmlspecialchars($film->getGenre()) ?></td>
                        <td>Rp <?= number_format($film->getHarga(), 0, ',', '.') ?></td>
                        <td><code><?= htmlspecialchars($film->getGambar()) ?></code></td>
                        <td style="text-align: center;">
                            <a href="index.php?edit=<?= htmlspecialchars($film->getId()) ?>" class="action-link">Edit</a>
                            <a href="index.php?hapus=<?= htmlspecialchars($film->getId()) ?>" class="action-delete" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
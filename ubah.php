<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


require 'functions.php';

// ambil data di URL
$id = $_GET["id"];
// query data berdasarkan id
$animeById = query("SELECT * FROM anime_list WHERE id=$id")[0];


// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah data berhasil diubah atau tidak
  if (ubah($_POST) > 0) {
    echo "
    <script>
      alert('Data berhasil diubah!');
      document.location.href = 'index.php';
    </script>";
  } else if (ubah($_POST) == 0) {
    echo "
    <script>
      alert('Tidak ada data yang diubah!');
      document.location.href = 'index.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Data gagal diubah!');
      document.location.href = 'index.php';
    </script>";
  }
}

// menampilkan genre
// Cek apakah genre adalah string JSON
$genres = json_decode($animeById["genre"], true);

// Jika genre adalah array, ubah ke format string
if (is_array($genres)) {
  // Gabungkan elemen array menjadi satu string dengan koma sebagai pemisah
  $genreString = implode(", ", $genres);
} else {
  // Jika bukan array, gunakan nilai aslinya
  $genreString = $animeById["genre"];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Anime</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container mb-5">

    <h1 class="my-3 text-center">Ubah Data Anime</h1>

    <div class="row">
      <div class="col-6 mx-auto">
        <a href="index.php" class="btn btn-primary btn-sm mb-3"><- Kembali</a>

            <form action="" method="post" enctype="multipart/form-data">

              <div class="mb-3">
                <input type="hidden" class="form-control" id="id" name="id" required value="<?= $animeById["id"] ?>">
                <input type="hidden" class="form-control" name="gambarLama" required value="<?= $animeById["gambar"] ?>">
              </div>

              <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required value="<?= $animeById["judul"] ?>">
              </div>

              <div class="mb-3">
                <label for="season" class="form-label">Season</label>
                <input type="text" class="form-control" id="season" name="season" required value="<?= $animeById["season"] ?>">
              </div>

              <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required value="<?= $genreString ?>">
              </div>

              <div class="mb-3">
                <label for="episode" class="form-label">Episode</label>
                <input type="number" class="form-control" id="episode" name="episode" required value="<?= $animeById["episode"] ?>">
              </div>

              <div class="mb-3">
                <label for="studio" class="form-label">Studio</label>
                <input type="text" class="form-control" id="studio" name="studio" required value="<?= $animeById["studio"] ?>">
              </div>

              <div class="mb-3">
                <label for="skor" class="form-label">Skor</label>
                <input type="text" class="form-control" id="skor" name="skor" required value="<?= $animeById["skor"] ?>">
              </div>

              <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <img src="img/<?= $animeById["gambar"]; ?>" alt="" width="100" class="d-block mb-2">
                <input type="file" class="form-control" id="gambar" name="gambar">
              </div>

              <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
            </form>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>
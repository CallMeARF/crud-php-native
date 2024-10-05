<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah data berhasil ditambahkan atau tidak
  if (tambah($_POST) > 0) {
    echo "
    <script>
      alert('Data berhasil ditambahkan!');
      document.location.href = 'index.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Data gagal ditambahkan!');
      document.location.href = 'index.php';
    </script>";
  }
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

    <h1 class="my-3 text-center">Tambah Data Anime</h1>

    <div class="row">
      <div class="col-6 mx-auto">
        <a href="index.php" class="btn btn-primary btn-sm mb-3"><- Kembali</a>

            <form action="" method="post" enctype="multipart/form-data">

              <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
              </div>

              <div class="mb-3">
                <label for="season" class="form-label">Season</label>
                <input type="text" class="form-control" id="season" name="season" required>
              </div>

              <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
              </div>

              <div class="mb-3">
                <label for="episode" class="form-label">Episode</label>
                <input type="number" class="form-control" id="episode" name="episode" required>
              </div>

              <div class="mb-3">
                <label for="studio" class="form-label">Studio</label>
                <input type="text" class="form-control" id="studio" name="studio" required>
              </div>

              <div class="mb-3">
                <label for="skor" class="form-label">Skor</label>
                <input type="text" class="form-control" id="skor" name="skor" required>
              </div>

              <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>
              </div>

              <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            </form>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>
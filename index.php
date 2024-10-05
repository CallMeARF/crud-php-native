<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// Pagination
// Konfigurasi
$jmlDataPerHal = 3;
$keyword = '';
$animes = [];

// Cek apakah tombol cari ditekan
if (isset($_POST["cari"])) {
  // Jika tombol cari ditekan, simpan keyword ke session atau hapus session jika pencarian kosong
  if ($_POST["keyword"] === "") {
    unset($_SESSION['keyword']); // Menghapus session jika pencarian kosong
  } else {
    $keyword = $_POST["keyword"];
    $_SESSION['keyword'] = $keyword;
  }
} elseif (isset($_SESSION['keyword'])) {
  // Jika sudah ada keyword di session, gunakan keyword tersebut
  $keyword = $_SESSION['keyword'];
}

// Jika ada keyword pencarian, hitung jumlah data berdasarkan pencarian
if ($keyword) {
  $jmlData = count(query("SELECT * FROM anime_list 
                            WHERE judul LIKE '%$keyword%' OR
                                  season LIKE '%$keyword%' OR
                                  LOWER(JSON_UNQUOTE(genre)) LIKE '%$keyword%' OR
                                  episode LIKE '%$keyword%' OR
                                  studio LIKE '%$keyword%' OR
                                  skor LIKE '%$keyword%'"));
} else {
  // Jika tidak ada pencarian, hitung total data
  $jmlData = count(query("SELECT * FROM anime_list"));
}

$jmlHal = ceil($jmlData / $jmlDataPerHal);
$halAktif = isset($_GET["hal"]) ? $_GET["hal"] : 1;
$awalData = ($jmlDataPerHal * $halAktif) - $jmlDataPerHal;

// Ambil data berdasarkan pencarian atau semua data
if ($keyword) {
  $animes = cari($keyword, $awalData, $jmlDataPerHal);
} else {
  $animes = query("SELECT * FROM anime_list LIMIT $awalData, $jmlDataPerHal");
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container">

    <h1 class="my-3 text-center">Anime List</h1>

    <div class="row">
      <div class="col-md-4 mx-auto">
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="keyword" placeholder="Cari anime..." autofocus value="<?= $keyword; ?>">
            <button class="btn btn-outline-primary" type="submit" name="cari">Cari</button>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="d-flex justify-content-start">

          <a href="tambah.php" class="btn btn-primary btn-sm mb-3">Tambah Anime +</a>

          <a href="cetak.php" class="btn btn-primary btn-sm mb-3 mx-3" target="_blank">Download PDF</a>

          <a href="logout.php?token=<?= md5($_SESSION['login']) ?>" class="btn btn-danger btn-sm mb-3 ms-auto">Logout</a>

        </div>

        <table class="table table-striped mx-auto">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Judul</th>
              <th scope="col">Season</th>
              <th scope="col">Genre</th>
              <th scope="col">Episode</th>
              <th scope="col">Studio</th>
              <th scope="col">Skor</th>
              <th scope="col">Gambar</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1 + $awalData; ?>
            <?php foreach ($animes as $anime) : ?>
              <tr>
                <th scope="row"><?= $i; ?></th>
                <td><?= $anime["judul"]; ?></td>
                <td><?= $anime["season"]; ?></td>
                <td>
                  <?php
                  // Dekode string JSON dari kolom genre menjadi array PHP
                  $genres = json_decode($anime["genre"], true);
                  ?>
                  <?php if (is_array($genres)) : ?>
                    <?php
                    $genreList = "";
                    foreach ($genres as $key => $genre) {
                      $genreList .= $genre;
                      // Tambahkan koma jika bukan elemen terakhir
                      if ($key !== array_key_last($genres)) {
                        $genreList .= ", ";
                      }
                    }
                    echo $genreList;
                    ?>
                  <?php else : ?>
                    <?= $anime["genre"]; // Jika bukan array, tampilkan langsung 
                    ?>
                  <?php endif; ?>
                </td>
                <td><?= $anime["episode"]; ?></td>
                <td><?= $anime["studio"]; ?></td>
                <td><?= $anime["skor"]; ?></td>
                <td>
                  <img src="img/<?= $anime["gambar"]; ?>" alt="" width="50">
                </td>
                <td>
                  <a href="ubah.php?id=<?= $anime["id"]; ?>" class="btn btn-warning btn-sm mb-3">Ubah</a>
                  <a href="hapus.php?id=<?= $anime["id"]; ?>" class="btn btn-danger btn-sm mb-3" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <nav aria-label="Page navigation example">
          <ul class="pagination">

            <?php if ($halAktif > 1): ?>
              <li class="page-item"><a class="page-link" href="?hal=<?= $halAktif - 1; ?><?= $keyword ? '&keyword=' . $keyword : '' ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $jmlHal; $i++) : ?>
              <?php if ($i == $halAktif) : ?>
                <li class="page-item"><a class="page-link page-item active" href="?hal=<?= $i; ?><?= $keyword ? '&keyword=' . $keyword : '' ?>"><?= $i; ?></a></li>
              <?php else: ?>
                <li class="page-item"><a class="page-link" href="?hal=<?= $i; ?><?= $keyword ? '&keyword=' . $keyword : '' ?>"><?= $i; ?></a></li>
              <?php endif; ?>
            <?php endfor; ?>

            <?php if ($halAktif < $jmlHal): ?>
              <li class="page-item"><a class="page-link" href="?hal=<?= $halAktif + 1; ?><?= $keyword ? '&keyword=' . $keyword : '' ?>">Next</a></li>
            <?php endif; ?>

          </ul>
        </nav>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
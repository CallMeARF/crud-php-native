<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

// mysqli_report(MYSQLI_REPORT_OFF); = menonaktifkan uncaught mysqli_sql_exception

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function tambah($data)
{
  global $conn;

  $judul = htmlspecialchars($data["judul"]);
  $season = htmlspecialchars($data["season"]);
  $genre = htmlspecialchars($data["genre"]);
  $episode = htmlspecialchars($data["episode"]);
  $studio = htmlspecialchars($data["studio"]);
  $skor = htmlspecialchars($data["skor"]);

  //upload gambar
  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  // Konversi genre menjadi JSON string
  $genreArray = explode(", ", $genre); // Mengubah string menjadi array
  $genreJson = json_encode($genreArray); // Mengubah array menjadi JSON string

  // query insert data
  $query = "INSERT INTO anime_list
   VALUES
   (0, '$judul', '$season', '$genreJson', $episode, '$studio', $skor, '$gambar')";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function upload()
{
  $namaFile = $_FILES["gambar"]["name"];
  $ukuranFile = $_FILES["gambar"]["size"];
  $error = $_FILES["gambar"]["error"];
  $tmpName = $_FILES["gambar"]["tmp_name"];

  // cek apakah tidak ada gambar yang di-upload
  if ($error === 4) {
    echo "<script>alert('Pilih gambar dulu!')</script>";

    return false;
  }

  // cek apakah yang di-upload gambar
  $ekstensiGambarValid = ["jpg", "jpeg", "png"];
  $ekstensiGambar = explode(".", $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));

  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>alert('Yang anda upload bukan gambar!')</script>";

    return false;
  }

  // cek jika ukurannya terlalu besar
  if ($ukuranFile > 2000000) {
    echo "<script>alert('Ukuran gambar terlalu besar!')</script>";

    return false;
  }

  // lolos pengecekan gambar siap di-upload
  // generate nama gambar baru
  $namaFileBaru = uniqid();
  $namaFileBaru .= ".";
  $namaFileBaru .= $ekstensiGambar;
  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

  return $namaFileBaru;
}

function hapus($id)
{
  global $conn;

  // Ambil data gambar berdasarkan id
  $anime = query("SELECT gambar FROM anime_list WHERE id = $id")[0];
  $gambar = $anime["gambar"];

  // Hapus file gambar dari folder img
  if (file_exists('img/' . $gambar)) {
    unlink('img/' . $gambar);
  }

  mysqli_query($conn, "DELETE FROM anime_list WHERE id=$id");

  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $judul = htmlspecialchars($data["judul"]);
  $season = htmlspecialchars($data["season"]);
  $genre = htmlspecialchars($data["genre"]);
  $episode = htmlspecialchars($data["episode"]);
  $studio = htmlspecialchars($data["studio"]);
  $skor = htmlspecialchars($data["skor"]);
  $gambarLama = htmlspecialchars($data["gambarLama"]);

  // cek apakah user pilih gambar baru atau tidak
  if ($_FILES["gambar"]["error"] === 4) {
    $gambar = $gambarLama;
  } else {
    // Jika ada gambar baru, hapus gambar lama dari folder
    if (file_exists('img/' . $gambarLama)) {
      unlink('img/' . $gambarLama); // Menghapus gambar lama
    }
    $gambar = upload(); // Mengupload gambar baru
  }

  // Konversi genre menjadi JSON string
  $genreArray = explode(", ", $genre); // Mengubah string menjadi array
  $genreJson = json_encode($genreArray); // Mengubah array menjadi JSON string

  // query update data
  $query = "UPDATE anime_list
  SET
   judul = '$judul', 
   season ='$season', 
   genre = '$genreJson', 
   episode = $episode, 
   studio = '$studio', 
   skor = $skor, 
   gambar = '$gambar'
  WHERE id=$id
   ";

  if (mysqli_query($conn, $query)) {
    return mysqli_affected_rows($conn);
  } else {
    // Jika tidak ada baris yang berubah, kembalikan 0 sebagai indikator
    return 0;
  }
}

function cari($keyword, $awalData, $jmlDataPerHal)
{
  global $conn;
  $keyword = mysqli_real_escape_string($conn, $keyword); // Mencegah SQL Injection
  $query = "SELECT * FROM anime_list
              WHERE 
              judul LIKE '%$keyword%' OR
              season LIKE '%$keyword%' OR
              LOWER(JSON_UNQUOTE(genre)) LIKE '%$keyword%' OR
              episode LIKE '%$keyword%' OR
              studio LIKE '%$keyword%' OR
              skor LIKE '%$keyword%'
              LIMIT $awalData, $jmlDataPerHal";
  return query($query);
}


function register($data)
{
  global $conn;

  $username = strtolower(stripslashes($data["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["confirm_password"]);

  // cek apakah username sudah ada atau belum
  $result = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");

  if (mysqli_fetch_assoc($result)) {
    echo "
    <script>
      alert('Username sudah terdaftar!');
    </script>";

    return false;
  }

  // cek konfirmasi password
  if ($password !== $password2) {
    echo "
    <script>
      alert('Konfirmasi password tidak sesuai!');
    </script>";

    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // tambahkan user ke database
  mysqli_query($conn, "INSERT INTO users VALUES(0, '$username', '$password')");

  return mysqli_affected_rows($conn);
}

<?php
session_start();
require 'functions.php';

// cek cookie
if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
  $id = $_COOKIE["id"];
  $key = $_COOKIE["key"];

  // ambil username berdasarkan id
  $result = mysqli_query($conn, "SELECT username FROM users WHERE id=$id");
  $row = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if ($key === hash("sha256", $row["username"])) {
    $_SESSION["login"] = true;
  }
}

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

if (isset($_POST["login"])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

  // cek username
  if (mysqli_num_rows($result) === 1) {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      // set session
      $_SESSION["login"] = true;

      // cek remember me
      if (isset($_POST["remember"])) {
        // buat cookie
        setcookie("id", $row["id"], time() + 60);
        setcookie("key", hash("sha256", $row["username"]), time() + 60);
      }

      header("Location: index.php");

      exit;
    }
  }

  $error = true;
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header text-center">
            <h3>Login</h3>
          </div>
          <div class="card-body">

            <?php if (isset($error)) : ?>
              <div class="alert alert-danger" role="alert">
                Username / Password Salah!
              </div>
            <?php endif; ?>

            <form action="" method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
              </div>
              <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
            </form>
          </div>
          <div class="card-footer text-center">
            <small>Belum punya akun? <a href="registrasi.php">Daftar di sini</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();

if (!isset($_GET['token']) || $_GET['token'] !== md5($_SESSION['login'])) {
  header("Location: index.php");
  exit;
}


$_SESSION = [];
session_destroy();
session_unset();

setcookie("id", "", time() - 3600);
setcookie("key", "", time() - 3600);

header("Location: login.php");
exit;

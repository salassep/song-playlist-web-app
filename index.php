<?php
require 'config.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main-style.css">
  <link rel="stylesheet" href="css/navbar-style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Halaman Utama</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="vh-center">
    <h1>Listening is everything</h1>
    <h3>Sharing your playlists with your friends</h3>
    <a href="lihatPlaylist.php"><span class="button">LET'S GO</span></a>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
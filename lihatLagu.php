<?php
require 'config.php';
require 'functions/songFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$genres = readGenre($conn);

if (isset($_GET['submit'])) {
  $genreId = $_GET['sgenre'];
  $title = $_GET['search'];
  $songs = readSongsByGenre($conn, $genreId, $title);
} else {
  $songs = readSongs($conn);
}

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
  <link rel="stylesheet" href="css/lihat-lagu-style.css">
  <title>Songs</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Songs</h1>
    <div class="action">
      <a href="tambahLagu.php"><i class="fas fa-plus-circle"></i> Add Song</a>
      <form action="" method="GET">
        <select name="sgenre" id="sgenre">
          <option value="All">All</option>
          <?php while ($genre = mysqli_fetch_assoc($genres)) {?>
            <option value="<?= $genre['id'] ?>"><?= $genre['genre_name'] ?></option>
          <?php } ?>
        </select>
        <input type="search" name="search" id="search" placeholder="songs title..." autocomplete="off">
        <button type="submit" name="submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
    <div class="songs-list">
      <?php while ($song = mysqli_fetch_assoc($songs)) {?>
        <ul class="songs-card">
          <div class="card-right">
            <li>Title : <a href="lihatDetailLagu.php?id=<?= $song['id'] ?>"><?= $song['title'] ?></a> </li>
            <li>Artist : <?= $song['artist'] ?></li>
            <li>Uploaded by : <a href="halamanProfil.php?username=<?= $song['uploader'] ?>"><?= $song['uploader'] ?></a></li>
          </div>
          <div class="card-left">
            <li>Duration : <?= $song['duration'] ?></li>
          </div>
        </ul>
      <?php } ?>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
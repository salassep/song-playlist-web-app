<?php 
require 'config.php';
require 'functions/songFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];
$song = readDetailSong($conn, $id);

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
  <link rel="stylesheet" href="css/lihat-detail.css">
  <title>Songs</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Song Details</h1>
    <div class="detail-song">
      <div class="the-song">
        <h1><i class="fas fa-music"></i></h1>
        <audio controls>
            <source src="assets/songs/<?= $song['song_file'] ?>" type="audio/mpeg">
          Browser anda tidak mendukung pemutaran lagu.
        </audio>
      </div>
      <div class="the-detail">
        <ul>
          <li>Title : <?= $song['title'] ?></li>
          <li>Artist : <?= $song['artist'] ?></li>
          <li>Year : <?= $song['year'] ?></li>
          <li>Album : <?= $song['album'] ?></li>
          <li>Duration : <?= $song['duration'] ?></li>
          <li>Genre : <?= $song['genre_name'] ?></li>
          <li>Last Modified : <?= $song['updated_at'] ?></li>
          <li>Uploaded On : <?= $song['inserted_at'] ?> by <a href="halamanProfil.php?username=<?= $song['uploader'] ?>"><?= $song['uploader'] ?></a></li>
        </ul><br>
        <?php if ($song['uploader'] == $_SESSION['username']) { ?>
          <a href="editLagu.php?id=<?= $id ?>"><i class="fas fa-pen-square"></i> Update &nbsp&nbsp</a>
          <a href="hapusLagu.php?id=<?= $id ?>"><i class="fas fa-minus-square"></i> Delete &nbsp&nbsp</a>
        <?php } ?>
        <a href="pilihPlaylist.php?song=<?= $song['id'] ?>"><i class="fas fa-headphones"></i> Add Song to Playlist</a>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
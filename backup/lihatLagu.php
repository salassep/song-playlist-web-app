<?php
require 'config.php';
require 'functions/songFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$songs = readSongs($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lihat lagu</title>
</head>
<body>
  <h1>daftar lagu</h1>
  <?php while ($song = mysqli_fetch_assoc($songs)) {?>
    <ul>
      <li>Judul : <a href="lihatDetailLagu.php?id=<?= $song['id'] ?>"><?= $song['title'] ?></a> </li>
      <li>Artist : <?= $song['artist'] ?></li>
      <li>Duration : <?= $song['duration'] ?></li>
      <li>Uploaded by : <?= $song['uploader'] ?></li>
    </ul>
  <?php } ?>
</body>
</html>
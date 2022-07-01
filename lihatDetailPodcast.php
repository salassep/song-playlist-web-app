<?php 
require 'config.php';
require 'functions/podcastFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];
$podcast = readDetailPodcast($conn, $id);

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
  <title>Podcasts</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Podcast Details</h1>
    <div class="detail-song">
      <div class="the-song">
      <h1><i class="fas fa-podcast"></i></h1>
        <audio controls>
            <source src="assets/podcasts/<?= $podcast['podcast_file'] ?>" type="audio/mpeg">
          Browser anda tidak mendukung pemutaran lagu.
        </audio>
      </div>
      <div class="the-detail">
        <ul>
          <li>Title : <?= $podcast['title'] ?></li>
          <li>Artist : <?= $podcast['artist'] ?></li>
          <li>Duration : <?= $podcast['duration'] ?></li>
          <li>Genre : <?= $podcast['genre_name'] ?></li>
          <li>Last Modified : <?= $podcast['updated_at'] ?></li>
          <li>Uploaded On : <?= $podcast['inserted_at'] ?> by <a href="halamanProfil.php?username=<?= $podcast['uploader'] ?>"><?= $podcast['uploader'] ?></a></li>
        </ul><br>
        <?php if ($podcast['uploader'] == $_SESSION['username']) { ?>
          <a href="editPodcast.php?id=<?= $id ?>"><i class="fas fa-pen-square"></i> Update &nbsp&nbsp</a>
          <a href="hapusPodcast.php?id=<?= $id ?>"><i class="fas fa-minus-square"></i> Delete &nbsp&nbsp</a>
        <?php } ?>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
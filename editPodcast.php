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
$genres = readGenre($conn);

if(isset($_POST['submit'])) {
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $duration = $_POST['duration'];
  $genre = $_POST['genre'];
  $podcastFile = $_FILES;

  updatePodcast($conn, $id, $title, $artist, $duration, $genre, $podcastFile);
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
  <link rel="stylesheet" href="css/styleadd.css">
  <title>Podcast</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Update Podcast</h1>
    <form class="add-song" action="" method="POST" enctype="multipart/form-data">
      <div class="left-form">
        <label for="title">Title</label><br>
        <input type="text" name="title" value="<?= $podcast['title'] ?>" id="title" required autocomplete="off"><br>
    
        <label for="artist">Artist</label><br>
        <input type="text" id="artist" name="artist" value="<?= $podcast['artist'] ?>" required autocomplete="off"><br>
    
        <label for="duration">Duration</label><br>
        <input type="time" id="duration" name="duration" value="<?= $podcast['duration'] ?>" required><br>
      </div>
      <div class="right-form">
        <label for="genre">Genre : <?= $podcast['genre_name'] ?></label><br>
        <select name="genre" id="genre">
          <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
            <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
          <?php } ?>
        </select><br>
    
        <label for="songFile">Song File : <?= $podcast['podcast_file'] ?></label><br>
        <input type="file" id="songFile" name="podcast_file"><br>
    
        <button type="submit" name="submit">Update</button>
      </div>
    </form>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
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
$genres = readGenre($conn);

if(isset($_POST['submit'])) {
  $title = $_POST['title'];
  $year = $_POST['year'];
  $artist = $_POST['artist'];
  $album = $_POST['album'];
  $duration = $_POST['duration'];
  $genre = $_POST['genre'];
  $songFile = $_FILES;

  updateSong($conn, $id, $title, $year, $artist, $album, $duration, $genre, $songFile);
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
  <title>Song</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Update Song</h1>
    <form class="add-song" action="" method="POST" enctype="multipart/form-data">
      <div class="left-form">
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title" value="<?= $song['title'] ?>" required autocomplete="off"><br>
        
        <label for="artist">Artist</label><br>
        <input type="text" id="artist" name="artist" value="<?= $song['artist'] ?>" required autocomplete="off"><br>
        
        <label for="year">Year</label><br>
        <input type="text" id="year" name="year" value="<?= $song['year'] ?>" required autocomplete="off"><br>
    
        <label for="album">Album</label><br>
        <input type="text" id="album" name="album" value="<?= $song['album'] ?>" autocomplete="off"><br>
    
        <label for="duration">Duration</label><br>
        <input type="time" id="duration" name="duration" value="<?= $song['duration'] ?>"  required autocomplete="off"><br>
      </div>
      <div class="right-form">
        <label for="genre">Genre : <?= $song['genre_name'] ?></label><br>
        <select name="genre" id="genre">
          <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
            <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
          <?php } ?>
        </select><br>
    
        <label for="songFile">Song File : <?= $song['song_file'] ?></label><br>
        <input type="file" id="songFile" name="song_file"><br>
    
        <button type="submit" name="submit">Update</button>
      </div>
    </form>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
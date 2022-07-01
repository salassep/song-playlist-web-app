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
  <title>Edit lagu</title>
</head>
<body>
  <h1>Edit lagu</h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Title</label><br>
    <input type="text" name="title" value="<?= $song['title'] ?>"><br>

    <br><label>Year</label><br>
    <input type="text" name="year" value="<?= $song['year'] ?>"><br>

    <br><label>Artist</label><br>
    <input type="text" name="artist" value="<?= $song['artist'] ?>"><br>

    <br><label>Album</label><br>
    <input type="text" name="album" value="<?= $song['album'] ?>"><br>

    <br><label>Duration</label><br>
    <input type="time" name="duration" value="<?= $song['duration'] ?>"><br>
    
    <br><label>Genre : <?= $song['genre_name'] ?></label><br>
    <select name="genre" id="genre">
      <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
        <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
      <?php } ?>
    </select><br>

    <br><label>Song File : <?= $song['song_file'] ?></label><br>
    <input type="file" name="song_file" placeholder="Song File .."><br>

    <br><input type="submit" name="submit" value="SUBMIT">
  </form>
</body>
</html>
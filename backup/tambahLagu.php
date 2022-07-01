<?php
require 'config.php';
require 'functions/songFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$genres = readGenre($conn);

if(isset($_POST['submit'])) {
  $id = $_SESSION['id'];
  $title = $_POST['title'];
  $year = $_POST['year'];
  $artist = $_POST['artist'];
  $album = $_POST['album'];
  $duration = $_POST['duration'];
  $genre = $_POST['genre'];
  $songFile = $_FILES;

  addSong($conn, $id, $title, $year, $artist, $album, $duration, $genre, $songFile);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah lagu</title>
</head>
<body>
  <h1>Tambah lagu</h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Title</label><br>
    <input type="text" name="title" placeholder="Tittle .."><br>

    <br><label>Year</label><br>
    <input type="text" name="year" placeholder="Year .."><br>

    <br><label>Artist</label><br>
    <input type="text" name="artist" placeholder="Artist .."><br>

    <br><label>Album</label><br>
    <input type="text" name="album" placeholder="Album .."><br>

    <br><label>Duration</label><br>
    <input type="time" name="duration" placeholder="duration .."><br>
    
    <br><label>Genre</label><br>
    <select name="genre" id="genre">
      <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
        <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
      <?php } ?>
    </select><br>

    <br><label>Song File</label><br>
    <input type="file" name="song_file" placeholder="Song File .."><br>

    <br><input type="submit" name="submit" value="SUBMIT">
  </form>
</body>
</html>
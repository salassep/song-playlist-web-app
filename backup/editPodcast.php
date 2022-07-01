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
  <title>Podcast</title>
</head>
<body>
  <h1>Edit Podcast</h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Title</label><br>
    <input type="text" name="title" value="<?= $podcast['title'] ?>"><br>

    <br><label>Artist</label><br>
    <input type="text" name="artist" value="<?= $podcast['artist'] ?>"><br>

    <br><label>Duration</label><br>
    <input type="time" name="duration" value="<?= $podcast['duration'] ?>"><br>
    
    <br><label>Genre : <?= $podcast['genre_name'] ?></label><br>
    <select name="genre" id="genre">
      <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
        <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
      <?php } ?>
    </select><br>

    <br><label>Song File : <?= $podcast['podcast_file'] ?></label><br>
    <input type="file" name="podcast_file"><br>

    <br><input type="submit" name="submit" value="SUBMIT">
  </form>
</body>
</html>
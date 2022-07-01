<?php 
require 'config.php';
require 'functions/podcastFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$genres = readGenre($conn);

if(isset($_POST['submit'])) {
  $id = $_SESSION['id'];
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $duration = $_POST['duration'];
  $genre = $_POST['genre'];
  $podcastFile = $_FILES;

  addPodcast($conn, $id, $title, $artist, $duration, $genre, $podcastFile);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Podcasts</title>
</head>
<body>
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Title</label><br>
    <input type="text" name="title" placeholder="Title .."><br>

    <br><label>Artist</label><br>
    <input type="text" name="artist" placeholder="Artist .."><br>

    <br><label>Duration</label><br>
    <input type="time" name="duration" placeholder="duration .."><br>

    <br><label>Genre</label><br>
    <select name="genre" id="genre">
      <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
        <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
      <?php } ?>
    </select><br>

    <br><label>Podcast File</label><br>
    <input type="file" name="podcast_file" placeholder="Podcast File .."><br>

    <br><input type="submit" name="submit" value="SUBMIT">
  </form>
</body>
</html>
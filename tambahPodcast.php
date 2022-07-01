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
  <link rel="stylesheet" href="css/main-style.css">
  <link rel="stylesheet" href="css/navbar-style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styleadd.css">
  <title>Podcast</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Add Podcast</h1>
    <form class="add-song" action="" method="POST" enctype="multipart/form-data">
      <div class="left-form">
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title" placeholder="Ex. Hidup itu berat" required autocomplete="off"><br>
  
        <label for="artist">Artist</label><br>
        <input type="text" id="artist" name="artist" placeholder="Ex. Innatubil Issa" required autocomplete="off"><br>
    
        <label for="duration">Duration</label><br>
        <input type="time" id="duration" name="duration" required><br>
      </div>
      <div class="right-form">
        <label for="genre">Genre</label><br>
        <select name="genre" id="genre">
          <?php while ($genre = mysqli_fetch_assoc($genres)) { ?>
            <option value="<?= $genre['id']?>"><?= $genre['genre_name'] ?></option>
          <?php } ?>
        </select><br>
    
        <label for="podcastFile">Podcast File</label><br>
        <input type="file" id="podcastFile" name="podcast_file"><br>
    
        <button type="submit" name="submit">Add</button>
      </div>
    </form>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
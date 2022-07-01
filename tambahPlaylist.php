<?php 
require "config.php";
require "functions/playlistFunctions.php";

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $picture = $_FILES;
  $owner = $_SESSION['id'];
  addPlaylist($conn, $name, $description, $picture, $owner);
};


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
  <link rel="stylesheet" href="css/tambah-playlist-style.css">
  <title>Playlists</title>
</head>
<body>
<?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
<div class="container">
  <h1>Add Playlist</h1>
  <div class="add-playlist">
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Name :</label><br>
        <input type="text" id="name" name="name" placeholder="Ex. My Favourite Song" required autocomplete="off"><br>

        <label for="desc">Description :</label><br>
        <textarea name="description" id="desc" cols="30" rows="10" ></textarea><br>
  
        <label for="playlistPict">Playlists Picture :</label><br>
        <input type="file" id="playlistPict" name="playlist_picture"><br>

        <button type="submit" name="submit">Add</button>
    </form>
  </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
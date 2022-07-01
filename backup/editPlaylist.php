<?php 
 require "config.php";
 require "functions/playlistFunctions.php";
 
 session_start();
 
 if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   exit;
 }

 $id = $_GET['id'];

 $playlist = readDetailPlaylist($conn, $id);

 if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $picture = $_FILES;
  updatePlaylist($conn, $id, $name, $description, $picture);
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Playlists</title>
</head>
<body>
<h1>Edit Playlist</h1>
  <form action="" method="POST" enctype="multipart/form-data">
      <label>Name</label><br>
      <input type="text" name="name" value="<?= $playlist['name'] ?>"><br>

      <br><label>Description</label><br>
      <input type="text" name="description" value="<?= $playlist['description'] ?>"><br>

      <br><label>Playlists Picture</label><br>
      <input type="file" name="playlist_picture"><br>

      <br><input type="submit" name="submit" value="SUBMIT">
  </form>
</body>
</html>
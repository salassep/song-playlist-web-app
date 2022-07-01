<?php 
 require "config.php";
 require "functions/playlistFunctions.php";
 
 session_start();
 
 if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   exit;
 }

 $owner = $_SESSION['id'];

 $playlists = readPlaylists($conn, $owner);

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
  <link rel="stylesheet" href="css/lihat-playlist-style.css">
  <title>Playlists</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Your Playlists</h1>
    <div class="playlists">
      <div class="card">
        <h1><a href="tambahPlaylist.php"><i class="fas fa-plus-circle"></i></a></h1>
      </div>
      <?php while ($playlist = mysqli_fetch_assoc($playlists)) {?>
        <div class="card">
          <img src="assets/img/playlists/<?= $playlist['playlist_picture'] ?>" alt="" width="200" height="200">
          <a href="lihatDetailPlaylist.php?id=<?= $playlist['id'] ?>"><?= $playlist['name'] ?></a>
        </div>
      <?php } ?>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
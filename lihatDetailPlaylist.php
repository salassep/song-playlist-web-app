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
$songs = readSongsInPlaylist($conn, $id);

if (isset($_POST['collab'])) {
  $usernameCollaborator = $_POST['username'];
  $playlistId = $playlist['id'];
  addCollaborator($conn, $usernameCollaborator, $playlistId);
}

$collaborators = readCollaborators($conn, $id);

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
  <link rel="stylesheet" href="css/detail-playlist-style.css">
  <title>Playlists</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <h1>Detail Playlist</h1>
    <div class="detail-playlist">
      <div class="box-left">
        <ul>
          <li><img src="assets/img/playlists/<?= $playlist['playlist_picture'] ?>" alt="" width="150" height="150"></li>
          <li style="font-weight: 600;"><?= $playlist['name'] ?></li>
          <li><?= $playlist['description'] ?></li>
          <li style="font-weight: 300; font-size:14px;">Created on <?= $playlist['date'] ?> by <?= $playlist['owner'] ?></li>
        </ul>
        <?php if ($_SESSION['id'] == $playlist['owner_id']) { ?>
          <p style="font-weight:500;">Collaborators : </p>
          <ul>
            <?php while ($collaborator = mysqli_fetch_assoc($collaborators)) {?>
              <li><?= $collaborator['username'] ?> <a href="hapusCollaborator.php?playlist=<?= $playlist['id'] ?>&collab=<?= $collaborator['id'] ?>">&nbsp<i class="fas fa-user-minus"></i></a></li>
            <?php } ?>
          </ul>
          <form action="" method="POST">
            <br><label for="collab" style="font-weight:500;">Add Collaborator : </label>
            <input type="text" name="username" id="collab" autocomplete="off" placeholder="username" required>
            <button type="submit" name="collab">&nbsp<i class="fas fa-user-plus"></i></button><br><br>
          </form>
          <br><a href="editPlaylist.php?id=<?= $playlist['id'] ?>"><i class="fas fa-pen-square"></i> Update Playlist&nbsp&nbsp</a>
          <a href="hapusPlaylist.php?id=<?= $playlist['id'] ?>"><i class="fas fa-minus-square"></i> Delete Playlist</a>
        <?php } else {?>
          <p style="font-weight:500;">Collaborators : </p>
          <ul>
            <?php while ($collaborator = mysqli_fetch_assoc($collaborators)) {?>
              <li><?= $collaborator['username'] ?></li>
            <?php } ?>
          </ul>
        <?php } ?>
      </div>
      <div class="box-right">
      <br><a href="lihatLagu.php"><i class="fas fa-plus-circle"></i> Add Song</a><br><br>
        <?php while ($song = mysqli_fetch_assoc($songs)) {?>
          <ul>
            <li>
              <div class="song">
                <audio controls>
                  <source src="assets/songs/<?= $song['song_file'] ?>" type="audio/mpeg">
                  Browser anda tidak mendukung pemutaran lagu.
                </audio>
                <span><a href="hapusLaguPlaylist.php?song=<?= $song['id'] ?>&playlist=<?= $playlist['id'] ?>"><i class="fas fa-minus-circle"></i></a></span>
              </div>
            </li>
            <li><a href="lihatDetailLagu.php?id=<?= $song['id'] ?>"><?= $song['title'] ?></a>, <?= $song['artist'] ?> </li>
            <li></li>
          </ul>
        <?php } ?>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
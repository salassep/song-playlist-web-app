<?php 
require "config.php";
require "functions/playlistFunctions.php";

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$playlistId = $_GET['playlist'];
$songId = $_GET['song'];

$songPlaylist = addSongToPlaylist($conn, $playlistId, $songId);

if ($songPlaylist) {
  header("Location: lihatDetailPlaylist.php?id=$playlistId");
}

echo "<script>
        alert('Lagu sudah ada di dalam playlist!');
        window.location.href = 'lihatDetailPlaylist.php?id=".$playlistId."';
      </script>";

?>
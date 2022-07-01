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

deleteSongInPlaylist($conn, $playlistId, $songId);

header("Location: lihatDetailPlaylist.php?id=$playlistId");

?>
<?php 
require "config.php";
require "functions/playlistFunctions.php";

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$playlistId = $_GET['playlist'];
$collabId = $_GET['collab'];

deleteCollaborator($conn, $playlistId, $collabId);

header("Location: lihatDetailPlaylist.php?id=$playlistId");

?>
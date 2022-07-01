<?php 
require "config.php";
require "functions/playlistFunctions.php";

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];

deletePlaylist($conn, $id);

header("Location: lihatPlaylist.php");
?>
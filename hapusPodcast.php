<?php
require 'config.php';
require 'functions/podcastFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];

deletePodcast($conn, $id);

header("Location: lihatPodcast.php");
?>
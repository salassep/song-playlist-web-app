<?php
require 'config.php';
require 'functions/userFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];
$oldPassword = $_POST['oldPassword'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

changePassword($conn, $username, $oldPassword, $password, $cpassword);

?>
<?php 
require 'config.php';
require 'functions/userFunctions.php';

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_GET['username'];

$row = readUser($conn, $username);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main-style.css">
  <link rel="stylesheet" href="css/profil-page-style.css">
  <link rel="stylesheet" href="css/navbar-style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <title>Profile</title>
</head>
<body>
<?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <div class="cassetes"></div>
    <div class="woman"></div>
    <div class="orange-box"></div>
    <div class="profile">
      <h1><?= $row['username']?></h1>
      <?php if (!$row['profile_picture']) {?>
        <img src="assets/img/default.jpg" alt="foto profil" width="150" height="150">
      <?php } else {?>
        <img src="assets/img/profile/<?= $row['profile_picture'] ?>" alt="foto profil" width="150" height="150">
      <?php } ?>
      <div class="full-name">
        <span class="your-name">
          <?= $row['first_name']?> <?= $row['last_name']?></span>
        <span class="action">
        <?php if ($_SESSION['username'] == $row['username']) {?>
          <a href="editProfil.php?username=<?= $row['username'] ?>"><i class="fas fa-edit"></i></a>
        <?php } ?>
        </span>
      </div>
      <p>"<?= $row['bio']?>"</p>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
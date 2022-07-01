<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

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
  <link rel="stylesheet" href="css/about-style.css">
  <title>About Us</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="vh-center">
    <h1>About Us</h1><br>
    <ul>
      <li>Created by <b>Group 12</b> with &nbsp<i class="fas fa-mug-hot"></i></li><br>
      <li><b>Group 12</b></li>
      <li>Feriansyah / 1915016071</li>
      <li>Innatubil Issa / 1915016080</li>
      <li>Salas Sepkardianto / 1915016099</li><br>
      <li><b>Credit</b></li>
      <li><a href='https://www.freepik.com/photos/background' target="_blank">Background photo created by freepik - www.freepik.com</a></li>
      <li><a href='https://www.freepik.com/vectors/vintage' target="_blank">Vintage vector created by stories - www.freepik.com</a></li>
    </ul>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
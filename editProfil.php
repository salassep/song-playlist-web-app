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

if(isset($_POST['update'])) {
  $files = $_FILES;
  $newUsername = $_POST['username'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $bio = $_POST['bio'];
  updateUser($conn, $files, $username, $newUsername, $firstName, $lastName, $bio);
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
  <link rel="stylesheet" href="css/edit-profile-style.css">
  <title>Profile</title>
</head>
<body>
  <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/pa-web/assets/html/"; include($IPATH."navbar.html");?>
  <div class="container">
    <div class="box-left">
      <div class="vh-center">
        <h1>Update Profile</h1>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="profile-picture">
            <?php if (!$row['profile_picture']) {?>
              <img src="assets/img/default.jpg" alt="foto profil" width="100" height="100">
            <?php } else {?>
              <img src="assets/img/profile/<?= $row['profile_picture'] ?>" alt="foto profil" width="100" height="100">
            <?php } ?>
            <input type="file" id="profilePicture" name="profilePicture"><br/>
          </div>
          <label for="username">Username :</label><br>
          <input type="text" id="username" name="username" value="<?= $row['username'] ?>" required autocomplete="off"><br>
          <div class="name">
            <div class="first-name">
              <label for="firstName">First Name :</label><br>
              <input type="text" id="firstName" name="firstName" value="<?= $row['first_name'] ?>" required autocomplete="off"><br>
            </div>
            <div class="last-name">
              <label for="lastName">Last Name :</label><br>
              <input type="text" id="lastName" name="lastName" value="<?= $row['last_name'] ?>"  required autocomplete="off"><br>
            </div>
          </div>
          <label for="bio">Bio :</label><br>
          <textarea name="bio" id="bio" cols="30" rows="10" ><?= $row['bio'] ?></textarea><br>
          <label for="email">Email :</label><br>
          <input type="email" id="email" name="email" value="<?= $row['email'] ?>"  readonly><br>
          <a class="open-button" popup-open="popup-1" href="javascript:void(0)">Change Password</a>
          <button type="submit" name="update">SAVE</button>
        </form>
      </div>
    </div>
    <div class="box-right">
      <div class="waves-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffa235" fill-opacity="1" d="M0,128L40,149.3C80,171,160,213,240,213.3C320,213,400,171,480,128C560,85,640,43,720,26.7C800,11,880,21,960,37.3C1040,53,1120,75,1200,101.3C1280,128,1360,160,1400,176L1440,192L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>
      </div>
      <div class="waves-1">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffa235" fill-opacity="1" d="M0,160L40,144C80,128,160,96,240,80C320,64,400,64,480,96C560,128,640,192,720,208C800,224,880,192,960,165.3C1040,139,1120,117,1200,106.7C1280,96,1360,96,1400,96L1440,96L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>
      </div>
      <div class="waves-3"></div>
    </div>
      <div class="popup" popup-name="popup-1">
        <div class="change-pass">
          <p>Change Password</p>
          <form action="changePass.php" method="post">
            <label for="oldPassword">Old Password :</label>
            <input type="password" id="oldPassword" name="oldPassword" required autocomplete="off"><br>
            <label for="password">New Password :</label>
            <input type="password" id="password" name="password" required autocomplete="off"><br>
            <label for="cpassword">Confirm Password :</label>
            <input type="password" id="cpassword" name="cpassword" required autocomplete="off"><br>
            <button type="submit" name="change" class="dont">Change</button>
          </form>
          <a href="javascript:void(0)" class="close-button" popup-close="popup-1">x</a>
        </div>
     </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
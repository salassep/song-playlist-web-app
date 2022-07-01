<?php
require 'config.php';

session_start();

if (isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $cpassword = md5($_POST['cpassword']);

  if ($password == $cpassword) {
    $query = "SELECT * FROM users WHERE username='$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);
    if (!mysqli_num_rows($result) > 0) {
      $query = "INSERT INTO users (username, first_name, last_name, email, password) 
                VALUES ('$username', '$firstName', '$lastName', '$email', '$password')";
      $result = mysqli_query($conn, $query);
      if ($result) {
        echo "<script>
                alert('Registrasi berhasil !');
                window.location.href = 'login.php';
              </script>";
      } else {
        echo "<script>alert('Registrasi gagal !')</script>";
      }
    } else {
      echo "<script>alert('Username atau email sudah terdaftar !')</script>";
    }
  } else {
    echo "<script>alert('Konfirmasi password tidak sesuai !')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main-style.css">
  <link rel="stylesheet" href="css/login-style.css">
  <link rel="stylesheet" href="css/regis-style.css">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="box-right">
      <div class="vh-center">
        <h1>Sign Up for free</h1>
        <form action="" method="post">
          <label for="username">Username :</label>
          <input type="text" id="username" name="username" required autocomplete="off"><br>
          <div class="name">
            <div class="first-name">
              <label for="firstName">First Name :</label>
              <input type="text" id="firstName" name="firstName" required autocomplete="off"><br>
            </div>
            <div class="last-name">
              <label for="lastName">Last Name :</label>
              <input type="text" id="lastName" name="lastName" required autocomplete="off"><br>
            </div>
          </div>
          <label for="email">Email :</label><br>
          <input type="email" id="email" name="email" required autocomplete="off"><br>
          <label for="password">Password :</label>
          <input type="password" id="password" name="password" required autocomplete="off"><br>
          <label for="cpassword">Confirm Password :</label>
          <input type="password" id="cpassword" name="cpassword" required autocomplete="off"><br>
          <button type="submit" name="submit">SIGN UP</button>
        </form>
      </div>
    </div>
    <div class="box-left">
      <div class="vh-center">
        <div class="picture">
          <img src="assets/img/masmello.png" alt="masmello">
        </div>
        <h1>Already have an account?</h1>
        <p style="font-size: 18px; margin-bottom: 20px;">it’s easy to start,<br>just sign in with your email</p>
        <a href="login.php"><button>SIGN IN</button></a>
      </div>
    </div>
  </div>
</body>
</html>
<?php
require 'config.php';

session_start();

if (isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $query = "SELECT * FROM users WHERE email = '$email' AND password='$password'";
  $result = mysqli_query($conn, $query);
  
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['id'] = $row['id'];
    header("Location: index.php");
    exit;
  } else {
    echo "<script>alert('Username atau password anda salah !')</script>";
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
  <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="box-left">
      <div class="vertical-center">
        <h1>Listening is Everything</h1>
        <div class="picture">
          <img src="assets/img/login.png" alt="ilustrasi">
        </div>
        <p>Playing your <span style="color: rgb(209, 33, 181);">Mood</span><br>currently</p>
      </div>
    </div>
    <div class="box-right">
      <div class="vh-center">
        <h1>WELCOME BACK, </h1>
        <p>Log in now to continue</p>
        <div class="picture">
          <img src="assets/img/male.png" alt="ilustrasi" style="width:80%;">
        </div>
        <form action="" method="post">
          <input type="email" id="email" name="email" required autocomplete="off" placeholder="Email"><br/>
          <input type="password" id="password" name="password" required placeholder="Password"><br>
          <button type="submit" name="submit">LOG IN</button><br/>
        </form>  
        <p style="font-size: 12px;">doesn't have an account yet ? <a href="registrasi.php"><span style="color: rgb(209, 33, 181);">Sign Up</span></a></p>
      </div>
    </div>
  </div>
</body>
</html>
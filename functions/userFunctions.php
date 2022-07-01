<?php

function readUser($conn, $username) {
  $query = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    return $row;
  } else {
    echo "<script>
            alert('Pengguna tidak ditemukan !');
            window.location.href = 'index.php';
          </script>";
  }
}

function updatePicture($conn, $username, Array $files) {
    $result = mysqli_query($conn, "SELECT profile_picture FROM users WHERE username='$username'");
    $resultGambar = mysqli_fetch_array($result);

    $namaFile = $_FILES['profilePicture']['name'];
    $ukuranFile = $_FILES['profilePicture']['size'];
    $error = $_FILES['profilePicture']['error'];
    $tmpName = $_FILES['profilePicture']['tmp_name'];

    if(!$namaFile) {
        return $resultGambar['profile_picture'];
    }

    if($namaFile != $resultGambar['profile_picture']) {
        $path = 'assets/img/profile/'. $resultGambar['profile_picture'];
        if(file_exists($path)) {
            unlink($path);
        } else {
            echo "gagal menghapus file gambar sebelumnya";
        }
    }

    $ekstensi_diperbolehkan	= ['jpeg','jpg','png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar,$ekstensi_diperbolehkan)) {
        echo "<script>alert('Format file tidak sesuai !')</script>";
        return false;
    }
    if($ukuranFile > 1044070){
        echo "<script>alert('Ukuran file terlalu besar !')</script>";
        return false;   
    }

    move_uploaded_file($tmpName, 'assets/img/profile/' . $namaFile);
    return $namaFile;
}

function updateUser($conn, Array $files, $username, $newUsername ,$firstName, $lastName, $bio) {
  $profilePicture = updatePicture($conn, $username, $files);
  $query = "SELECT * FROM users WHERE username = '$newUsername'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  if (mysqli_num_rows($result) == 0 || $username == $row['username']) {
    $query = mysqli_query($conn, "UPDATE users SET username='$newUsername', first_name='$firstName', last_name='$lastName', profile_picture='$profilePicture', bio='$bio' WHERE username = '$username'");
    $_SESSION['username'] = $newUsername;
    header("Location: index.php");
  } else {
    echo "<script>alert(\"Username $newUsername telah terdaftar. Silahkan gunakan username lain.\")</script>";
  }
}

function changePassword($conn, $username, $oldPass, $pass, $cpass) {
  $oldPassEncrypted = md5($oldPass);
  $passEncrypted = md5($pass);
  $cpassEncrypted = md5($cpass);
  $query = "SELECT * FROM users WHERE username = '$username' AND password = '$oldPassEncrypted'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    if ($passEncrypted == $cpassEncrypted) {
      $query = "UPDATE users SET password = '$passEncrypted'";
      $result = mysqli_query($conn, $query);
      header("Location: editProfil.php?username=$username");
    } else {
      echo "<script>
              alert('Konfirmasi password anda salah !');
              window.location.href = 'editProfil.php?username=$username'
            </script>";
    }
  } else {
    echo "<script>
            alert('Password lama anda salah !');
            window.location.href = 'editProfil.php?username=$username'
          </script>";
  }

}

?>
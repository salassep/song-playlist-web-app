<?php
function readGenre($conn) {
  $query = "SELECT * FROM genre WHERE podcast_genre = 'false'";
  $result = mysqli_query($conn, $query);
  
  return $result;
}


function uploadSong(Array $files, $songUpdate = NULL) {
  $namaFile = $_FILES['song_file']['name'];
  $ukuranFile = $_FILES['song_file']['size'];
  $error = $_FILES['song_file']['error'];
  $tmpName = $_FILES['song_file']['tmp_name'];

  if ($songUpdate) {
    $resultSong = mysqli_fetch_assoc($songUpdate);
    if(!$namaFile) {
      return $resultSong['song_file'];
    }
    if($namaFile != $resultSong['song_file']) {
        $path = 'assets/songs/'. $resultSong['song_file'];
        if(file_exists($path)) {
            unlink($path);
        } else {
            echo "gagal menghapus file sebelumnya";
        }
    }
  } else {
    if(!$namaFile) {
      return false;
    }
  }

  $ekstensi_diperbolehkan	= ['mp3'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if(!in_array($ekstensiFile,$ekstensi_diperbolehkan)) {
      echo "<script>alert('Format file tidak sesuai !')</script>";
      return false;
  }
  if($ukuranFile > 10485760){
      echo "<script>alert('Ukuran file terlalu besar !')</script>";
      return false;   
  }

  move_uploaded_file($tmpName, 'assets/songs/' . $namaFile);
  return $namaFile;
}


function addSong($conn, $id, $title, $year, $artist, $album, $duration, $genre, Array $files) {
  $insertedAt = date("d/m/Y");
  $updatedAt = date("d/m/Y");
  $songFile = uploadSong($files);
  $query = "INSERT INTO 
            songs (title, year, artist, album, duration, song_file, inserted_at, updated_at, genre_id, user_id) 
            VALUES
            ('$title', '$year', '$artist', '$album', '$duration', '$songFile', '$insertedAt', '$updatedAt', $genre, $id)";
  $result = mysqli_query($conn, $query);
  header("location: lihatLagu.php");
}


function readSongs($conn) {
  $query = "SELECT songs.id, title, artist, duration, username as uploader from songs INNER JOIN users ON users.id = songs.user_id";
  $result = mysqli_query($conn, $query);
 
  return $result;
}

function readSongsByGenre($conn, $genreId, $title = '') {
  if ($genreId == 'All') {
    $query = "SELECT songs.id, title, artist, duration, username as uploader from songs INNER JOIN users ON users.id = songs.user_id WHERE title LIKE '%$title%'";
    $result = mysqli_query($conn, $query);
  } else {
    $query = "SELECT songs.id, title, artist, duration, username as uploader from songs INNER JOIN users ON users.id = songs.user_id WHERE genre_id = $genreId AND title LIKE '%$title%'";
    $result = mysqli_query($conn, $query);
  }

  return $result;
}


function readDetailSong($conn, $id) {
  $query = "SELECT songs.id, title, year, album, song_file, inserted_at, updated_at, artist, duration, users.id AS user_id, username AS uploader, genre_name FROM songs INNER JOIN users ON users.id = songs.user_id INNER JOIN genre ON genre.id = songs.genre_id WHERE songs.id = $id";
  
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    return $row;
  } else {
    echo "<script>
            alert('Lagu tidak ditemukan !');
            window.location.href = 'index.php';
          </script>";
  }
}


function updateSong($conn, $id, $title, $year, $artist, $album, $duration, $genre, Array $files) {
  $updatedAt = date("d/m/Y");
  $songUpdate = mysqli_query($conn, "SELECT song_file FROM songs WHERE id = $id");
  $songFile = uploadSong($files, $songUpdate);
  $query = "UPDATE songs SET title='$title', year = '$year', artist = '$artist', album = '$album', duration= '$duration', song_file='$songFile', updated_at='$updatedAt', genre_id = $genre WHERE id = $id";
  $result = mysqli_query($conn, $query);
  header("Location: lihatDetailLagu.php?id=$id");
}

function deleteSong($conn, $id) {
  $query = "DELETE FROM songs WHERE id = $id";
  $result = mysqli_query($conn, $query);
}

?>
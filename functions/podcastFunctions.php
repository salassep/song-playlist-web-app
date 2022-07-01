<?php
function readGenre($conn) {
  $query = "SELECT * FROM genre WHERE podcast_genre = 'true'";
  $result = mysqli_query($conn, $query);
  
  return $result;
}

function uploadPodcast(Array $files, $podcastUpdate = NULL) {
  $namaFile = $_FILES['podcast_file']['name'];
  $ukuranFile = $_FILES['podcast_file']['size'];
  $error = $_FILES['podcast_file']['error'];
  $tmpName = $_FILES['podcast_file']['tmp_name'];

  if ($podcastUpdate) {
    $resultPodcast = mysqli_fetch_assoc($podcastUpdate);
    if(!$namaFile) {
      return $resultPodcast['podcast_file'];
    }
    if($namaFile != $resultPodcast['podcast_file']) {
        $path = 'assets/podcasts/'.$resultPodcast['podcast_file'];
        if(file_exists($path)) {
            unlink($path);
        } else {
            echo "gagal menghapus file sebelumnya";
        }
    }
  } else{
    if(!$namaFile) {
      return false;
    }
  }

  $ekstensi_diperbolehkan	= ['mp3'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if(!in_array($ekstensiFile, $ekstensi_diperbolehkan)) {
      echo "<script>alert('Format file tidak sesuai !')</script>";
      return false;
  }
  if($ukuranFile > 15728640){
      echo "<script>alert('Ukuran file terlalu besar !')</script>";
      return false;   
  }

  move_uploaded_file($tmpName, 'assets/podcasts/' . $namaFile);
  return $namaFile;
}

function addPodcast($conn, $id, $title, $artist, $duration, $genre, Array $files) {
  $insertedAt = date("d/m/Y");
  $updatedAt = date("d/m/Y");
  $podcastFile = uploadPodcast($files);
  $query = "INSERT INTO 
            podcasts (title, artist, duration, podcast_file, inserted_at, updated_at, genre_id, user_id) 
            VALUES
            ('$title', '$artist', '$duration', '$podcastFile', '$insertedAt', '$updatedAt', $genre, $id)";
  $result = mysqli_query($conn, $query);
  header("location: lihatPodcast.php");
}

function readPodcasts($conn) {
  $query = "SELECT podcasts.id, title, artist, duration, username as uploader from podcasts INNER JOIN users ON users.id = podcasts.user_id";
  $result = mysqli_query($conn, $query);
 
  return $result;
}

function readPodcastsByGenre($conn, $genreId, $title = '') {
  if ($genreId == 'All') {
    $query = "SELECT podcasts.id, title, artist, duration, username as uploader from podcasts INNER JOIN users ON users.id = podcasts.user_id WHERE title LIKE '%$title%'";
    $result = mysqli_query($conn, $query);
  } else {
    $query = "SELECT podcasts.id, title, artist, duration, username as uploader from podcasts INNER JOIN users ON users.id = podcasts.user_id WHERE genre_id = $genreId AND title LIKE '%$title%'";
    $result = mysqli_query($conn, $query);
  }

  return $result;
}

function readDetailPodcast($conn, $id) {
  $query = "SELECT podcasts.id, title, podcast_file, inserted_at, updated_at, artist, duration, users.id AS user_id, username AS uploader, genre_name FROM podcasts INNER JOIN users ON users.id = podcasts.user_id INNER JOIN genre ON genre.id = podcasts.genre_id WHERE podcasts.id = $id";
  
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    return $row;
  } else {
    echo "<script>
            alert('Podcast tidak ditemukan !');
            window.location.href = 'index.php';
          </script>";
  }
}

function updatePodcast($conn, $id, $title, $artist, $duration, $genre, Array $files) {
  $updatedAt = date("d/m/Y");
  $podcastUpdate = mysqli_query($conn, "SELECT podcast_file FROM podcasts WHERE id = $id");
  $podcastFile = uploadPodcast($files, $podcastUpdate);
  $query = "UPDATE podcasts SET title='$title', artist = '$artist', duration= '$duration', podcast_file='$podcastFile', updated_at='$updatedAt', genre_id = $genre WHERE id = $id";
  $result = mysqli_query($conn, $query);
  header("Location: lihatDetailPodcast.php?id=$id");
}

function deletePodcast($conn, $id) {
  $query = "DELETE FROM podcasts WHERE id = $id";
  $result = mysqli_query($conn, $query);
}
?>
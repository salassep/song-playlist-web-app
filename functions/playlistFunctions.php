<?php
function uploadPicture(Array $files, $pictureUpdate = NULL) {
  $namaFile = $_FILES['playlist_picture']['name'];
  $ukuranFile = $_FILES['playlist_picture']['size'];
  $error = $_FILES['playlist_picture']['error'];
  $tmpName = $_FILES['playlist_picture']['tmp_name'];

  if ($pictureUpdate) {
    $resultPicture = mysqli_fetch_assoc($pictureUpdate);
    if(!$namaFile) {
      return $resultPicture['playlist_picture'];
    }
    if($namaFile != $resultPicture['playlist_picture']) {
        $path = 'assets/img/playlists/'. $resultPicture['playlist_picture'];
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

  $ekstensi_diperbolehkan	= ['jpeg','jpg','png'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if(!in_array($ekstensiFile,$ekstensi_diperbolehkan)) {
      echo "<script>alert('Format file tidak sesuai !')</script>";
      return false;
  }
  if($ukuranFile > 1044070){
      echo "<script>alert('Ukuran file terlalu besar !')</script>";
      return false;   
  }

  move_uploaded_file($tmpName, 'assets/img/playlists/' . $namaFile);
  return $namaFile;
}

function addPlaylist($conn, $name, $description, Array $picture, $owner) {
  $madeAt = date("d/m/Y");
  $playlistPicture = uploadPicture($picture);

  $query = "INSERT INTO 
            playlists (name, description, date, playlist_picture, owner_id) 
            VALUES 
            ('$name', '$description', '$madeAt', '$playlistPicture', '$owner')";

  $result = mysqli_query($conn, $query);
  header("location: lihatPlaylist.php");
}

function readPlaylists($conn, $id) {
  $query = "SELECT playlists.id, playlists.name, playlist_picture FROM playlists LEFT JOIN users ON playlists.owner_id = users.id LEFT JOIN collaborators ON collaborators.playlist_id = playlists.id WHERE playlists.owner_id = $id OR collaborators.user_id = $id";
  $result = mysqli_query($conn, $query);

  return $result;
}

function readDetailPlaylist($conn, $id) {
  $query = "SELECT playlists.id, name, description, date, playlist_picture, owner_id, username AS owner FROM playlists INNER JOIN users ON users.id = playlists.owner_id WHERE playlists.id = $id";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $playlist = mysqli_fetch_assoc($result);
    return $playlist;
  } else {
    echo "<script>
            alert('Playlist tidak ditemukan !');
            window.location.href = 'index.php';
          </script>";
  }
}

function updatePlaylist($conn, $id, $name, $description, Array $picture) {
  $pictureUpdate = mysqli_query($conn, "SELECT playlist_picture FROM playlists WHERE id = $id");
  $pictureFile = uploadPicture($picture, $pictureUpdate);
  $query = "UPDATE playlists SET name = '$name', description = '$description', playlist_picture = '$pictureFile' WHERE id =$id";
  $result = mysqli_query($conn, $query);
  header("Location: lihatDetailPlaylist.php?id=$id");
}

function deletePlaylist($conn, $id) {
  $query = "DELETE FROM playlists WHERE id = $id";
  $result = mysqli_query($conn, $query);
}

function addSongToPlaylist($conn, $playlistId, $songId) {
  $query = "SELECT * FROM playlistsongs WHERE playlist_id = $playlistId AND song_id = $songId";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 0) {
    $query = "INSERT INTO playlistsongs (playlist_id, song_id) VALUES ($playlistId, $songId)";
    $result = mysqli_query($conn, $query);
    return $result;
  }
  return false;
}

function readSongsInPlaylist($conn, $playlistId) {
  $query = "SELECT songs.id, songs.title, songs.artist, songs.song_file FROM songs LEFT JOIN playlistsongs ON playlistsongs.song_id = songs.id LEFT JOIN playlists ON playlists.id = playlistsongs.playlist_id WHERE playlists.id = $playlistId";
  $result = mysqli_query($conn, $query);
  
  return $result;
}

function deleteSongInPlaylist($conn, $playlistId, $songId) {
  $query = "DELETE FROM playlistsongs WHERE playlist_id = $playlistId AND song_id = $songId";
  $result = mysqli_query($conn, $query);
}

function addCollaborator($conn, $usernameCollaborator, $playlistId) {
  $query = "SELECT id, username FROM users WHERE username = '$usernameCollaborator'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];
    $query = "SELECT * FROM collaborators WHERE playlist_id = $playlistId AND user_id = $userId";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
      $query = "INSERT INTO collaborators (playlist_id, user_id) VALUES ($playlistId, $userId)";
      $result = mysqli_query($conn, $query);
    } else {
      echo "<script> alert('Collaborator sudah ada !'); </script>";
    }
  } else {
    echo "<script> alert('Username tidak ditemukan !'); </script>";
  }
}

function readCollaborators($conn, $playlistId) {
  $query = "SELECT users.id, users.username FROM users LEFT JOIN collaborators ON collaborators.user_id = users.id LEFT JOIN playlists ON playlists.id = collaborators.playlist_id WHERE playlists.id = $playlistId";
  $result = mysqli_query($conn, $query);
  return $result;
}

function deleteCollaborator($conn, $playlistId, $collabId) {
  $query = "DELETE FROM collaborators WHERE playlist_id = $playlistId AND user_id = $collabId";
  $result = mysqli_query($conn, $query);
}
 
?>

<?php

require_once "Admin_Controller.php";
$admController = new Admin_Controller();
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file-import"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
session_start();


// Check if image file is a actual image or fake image
if(isset($_POST["btnimport"])) {

  // Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['alert'] = "Maaf, file sudah ada.";
    $uploadOk = 0;
  }
  
  // Check file size
  if ($_FILES["file-import"]["size"] > 1000000) {
    $_SESSION['alert'] = "Maaf, file yang di upload melebihi batas.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($FileType != "xls" && $FileType != "xlsx") {
    $_SESSION['alert'] = "Maaf, hanya file ber extention xls & xlsx.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $_SESSION['alert'] = "Maaf, tidak dapat mengupload file anda..";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["file-import"]["tmp_name"], $target_file)) {
      $_SESSION['alert'] = "File ". basename( $_FILES["file-import"]["name"]). " telah di upload.";
      $admController->db->query("insert into ht_tambah_data (nama_file, waktu_upload, ukuran_file, extention_file) 
      values ('".basename( $_FILES["file-import"]["name"])."', 
      '".date("Y-m-d H:i:s", time())."', '".$_FILES["file-import"]["size"]."', '".$FileType."')");
    } else {
        $_SESSION['alert'] = "Maaf, file tidak bisa di pindahkan.";
        }
    }

    echo ("<script>window.location.replace('index.php?page=datsiswa&sub=import')</script>");
}
?>
<?php

require_once(dirname(__FILE__) . '../../../veritrans-php-snap/Veritrans.php');
require_once "Siswa_Controller.php";
session_start();

//cek session login

if ($_SESSION['login'] != "siswa") {
    header("location:../../index.php");
    exit;
}
//object siswa controller
$siswaController = new Siswa_Controller();

$conn = $siswaController->db;

//Set Your server key
Veritrans_Config::$serverKey = "SB-Mid-server-FtctbZ-K_ECETtO6-2j-Eb4e";

// Uncomment for production environment
// Veritrans_Config::$isProduction = true;

// Enable sanitization
Veritrans_Config::$isSanitized = true;

// Enable 3D-Secure
Veritrans_Config::$is3ds = true;




$email = $_SESSION['email'];
$nis = 0;

$query_get_nis = $conn->query("select s.nis from data_siswa s inner join akun a on s.id_akun=a.id_akun where a.email='$email'");
$data_nis = $query_get_nis->fetch_assoc();
// var_dump(mysqli_fetch_assoc($query_get_nis));
if ($data_nis != null) {
    $nis = $data_nis['nis'];
}
$query_select = $conn->query("select * from data_siswa s 
    inner join kelas k on s.id_kelas=k.id_kelas 
    inner join akun a on s.id_akun=a.id_akun where s.nis='$nis'");
$data = $query_select->fetch_assoc();
$tahun_masuk = date_format(date_create($data['waktu_masuk']), "Y");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../mpti/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eI33X_JQ7lVsDz4C">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <title>Dashboard Santri <?= strtolower($data['nama']); ?></title>
    <style>
    </style>
</head>

<body>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="logo">
                <a href="#" class="nav-link">
                    <span class="logo-text">E PAYMENT SCHOOL</span>
                    <i class="fa fa-angle-double-right arrow-nav"></i>
                </a>
            </li>
            <li class="nav-profile">
                <div class="user-pic">
                    
                </div>
                <div class="text-profile">
                    <div class="name">
                        <span><?= $data['nama']; ?></span>
                    </div>
                    <div class="tag-user">
                        <span>Santri</span>
                    </div>
                    <div class="status">
                        <span>Active</span>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a href="?page=tagihan" class="nav-link">
                    <i class="fa fa-money"></i>
                    <span class="link-text">Pembayaran</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="?page=cicilan" class="nav-link" id="cicilan">
                    <i class="fa fa-credit-card"></i>
                    <span class="link-text">Cicilan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?page=history" class="nav-link" id="history">
                    <i class="fa fa-history"></i>
                    <span class="link-text">History</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="?page=setting" class="nav-link">
                    <i class="fa fa-cog"></i>
                    <span class="link-text">Pengaturan</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="modal fade" id="notifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notifikasi untuk anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($siswaController->ambilPesan(intval($data['nis']))['msg'] as $msg) : ?>
                            <a href="">
                                <li class="list-group-item"><?= $msg['message'] ?><i
                                        class="fa fa-trash float-right mt-1 ml-3"></i><i
                                        class="fa fa-envelope<?= ($msg['baca'] == "1") ? '-open' : null?> float-right mt-1"></i>
                                </li>
                            </a>
                            <?php endforeach  ?>
                            <!-- <li class="list-group-item">Dapibus ac facilisis in <i class="fa fa-trash float-right mt-1 ml-3"></i><i class="fa fa-envelope float-right mt-1"></i></li>
                            <li class="list-group-item">Vestibulum at eros <i class="fa fa-trash float-right mt-1 ml-3"></i><i class="fa fa-envelope float-right mt-1"></i></li>
                            <li class="list-group-item">Vestibulum at eros <i class="fa fa-trash float-right mt-1 ml-3"></i><i class="fa fa-envelope-open float-right mt-1"></i></li>
                            <li class="list-group-item">Vestibulum at eros <i class="fa fa-trash float-right mt-1 ml-3"></i><i class="fa fa-envelope-open float-right mt-1"></i></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col d-inline-flex justify-content-end">
                <!-- <a href="#notifikasi" class="m-3" id="notif-btn" data-toggle="modal" data-target="#notifikasi">
                    <i class="fas fa-bell" style="font-size:20px">
                        <span
                            class="badge badge-primary badge-pill"><?= $siswaController->ambilPesan(intval($data['nis']))['notif'] ?></span>
                    </i>
                </a> -->
                <div class="mt-2 d-flex" id="btn-dropdown">
                    <i class='fas fa-user-circle' style='font-size:36px'></i>
                    <div class="dropdown">
                        <span
                            class="p-2"><?= explode(" ", $data['nama'])[0]." ".explode(" ", $data['nama'])[1]; ?></span>
                        <span style="margin-top: 7px;">&#9660;</span>
                        <div class="dropdown-content">
                            <a href="?page=profil">Profile Saya</a>
                            <a href="?page=setting">Ubah Kata Sandi</a>
                            <a href="../../form/keluar.php?keluar=true">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <div class="position-absolute alert-primary alert fade <?= isset($_SESSION['alert']) ? 'show' : null ?>"
                id="alert" role="alert" style="z-index: 1;">
                <?= $_SESSION['alert'] ?></div>
        </div>
        <?php 
        $_SESSION['alert'] = null;
        ?>

        <?php
        if (isset($_GET['page'])) {
            if ($_GET['page'] == "tagihan") {
                include "tagihan.php";
            } else if ($_GET['page'] == "cicilan") {
                include "cicilan.html";
            } else if ($_GET['page'] == "history") {
                include "history.html";
            } else if ($_GET['page'] == "setting") {
                include "pengaturan.php";
            } else if ($_GET['page'] == "profil") {
                include "profil_saya.php";
            } else if ($_GET['page'] == "ubah-katasandi") {
                include "ubah_katasandi.php";
            } elseif ($_GET['page'] == "proses") {
                include "proses.php";
            }
        } else {
            include "tagihan.php";
        }

        $conn->close();

        ?>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
</body>
<script type="text/javascript">
$("#btn-dropdown").on("click", function() {
    if ($(".dropdown-content").css("display") == "none") {
        $(".dropdown-content").slideDown();
    } else {
        $(".dropdown-content").slideUp();
    }
});

setInterval(function() {
    $("#alert").each(function(index, elem) {
        var classOfAlert = elem.classList.value.split(' ');

        if (classOfAlert.includes("show")) {
            setTimeout(function() {
                elem.classList.remove("show");
            }, 3000);
        }
    });

}, 1000);
</script>

</html>
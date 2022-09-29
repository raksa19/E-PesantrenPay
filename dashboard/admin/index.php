<?php

session_start();
require_once "./Admin_Controller.php";
//cek session 

if ($_SESSION['login'] != "admin") {
    header("location:../../index.php");
    exit;
}

// object dari kelas admin_controller
$admController = new Admin_Controller();

$responOfDataUser = $admController->dataUserAkun($_SESSION['email']);

$data = ($responOfDataUser['status']) ? $responOfDataUser['data'] : null;

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="extensions/filter-control/bootstrap-table-filter-control.css"> -->
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Dashboard Admin</title>
    <style>
    </style>
</head>

<body>
    <nav class="navbar navbar-success bg-success">
        <ul class="navbar-nav">
            <li class="nav-profile">
                <div class="user-pic">
                    <img src="../../assets/icons/EPP.png" alt="">
                </div>
                    <span class="link-text">E - PESANTREN PAYMENT</span>
            </li>
            <li class="nav-profile">
                <div class="user-pic">
                    <img src="../../assets/icons/admin.png" alt="">
                </div>
                <div class="text-profile">
                    <div class="name">
                        <span><?= $data['nama']; ?></span>
                    </div>
                    <div class="tag-user">
                        <span><?= $data['nm_akses']; ?></span>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a href="?page=income" class="nav-link disabled">
                    <i class="fa fa-money"></i>
                    <span class="link-text">Income</span>
                </a>
            </li>
            <li class="nav-item dropdown-submenu">
                <a href="?page=datsiswa" class="nav-link">
                    <i class="fas fa-database"></i>
                    <span class="link-text">Data Santri</span>
                </a>
                <div class="dropdown-content-submenu">
                    <a href="?page=datsiswa" class="link-submenu">Data</a>
                    <a href="?page=datsiswa&sub=import" class="link-submenu">Import Data</a>
                    <a href="?page=datsiswa&sub=report" class="link-submenu">Report</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="?page=invoice" class="nav-link" id="history">
                    <i class="fas fa-receipt"></i>
                    <span class="link-text">Invoice</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="?page=repot" class="nav-link" id="history">
                    <i class="fas fa-file-export"></i>
                    <span class="link-text">Repot</span>
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
    <div class="container">
        <div class="row">
            <div class="col d-inline-flex justify-content-end">
                <div class="mt-2 d-flex p-2" id="btn-dropdown">
                    <i class='fas fa-user-circle' style='font-size:36px'></i>
                    <div class="dropdown">
                        <span
                            class="p-2"><?= explode(" ", strtoupper($data['nama']))[0]." ".explode(" ", strtoupper($data['nama']))[1]; ?></span>
                        <span style="margin-top: 7px;">&#9660;</span>
                        <div class="dropdown-content">
                            <a href="?page=profil">Profile Saya</a>
                            <a href="?page=ubah-katasandi">Ubah Kata Sandi</a>
                            <a href="?page=pesan">Notifikasi <span class="badge badge-primary float-right"></span></a>
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 bg-light">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <?php if (isset($_GET['page'])) : ?>
                <li class="breadcrumb-item <?= isset($_GET['sub']) ? null : 'active' ?>" aria-current="page">
                    <a href="?page=datsiswa"><?= ucfirst($_GET['page']) ?></a>
                </li>
                <?php if (isset($_GET['sub'])) : ?>
                <li class="breadcrumb-item <?= isset($_GET['sub']) ? 'active' : null ?>" aria-current="page">
                    <?= ucfirst($_GET['sub']) ?></li>
                <?php endif ?>
                <?php endif ?>

            </ol>
        </nav>
        <?php

        if (isset($_GET['page'])) {
            if ($_GET['page'] == "income") {
                include "income.php";
            } else if ($_GET['page'] == "datsiswa") {
                include "datsiswa.php";
            } else if ($_GET['page'] == "invoice") {
                include "invoice.php";
            } else if ($_GET['page'] == "setting") {
                include "pengaturan.php";
            } else if ($_GET['page'] == "profil") {
                include "profil_saya.php";
            } else if ($_GET['page'] == "ubah-katasandi") {
                include "ubah_katasandi.php";
            } else if ($_GET['page'] == "edit") {
                include "edit_siswa.php";
            }
        }
        else {
            include "datsiswa.php";
        }
        ?>
    </div>
    <!-- <i class="bi bi-alarm"></i> -->
    <script type="text/javascript">
    var tb_tr = document.getElementById("tb-tr");

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

    function xhrrequest(method, url, data = null, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                callback(this.responseText);
            }
        }
        xhr.send(data);
    }

    function shortTable() {
        var table, switching, x, y, i, rows, shouldSwitch;

        table = document.querySelector("#table")
        switching = true;

        rows = table.rows
        while (switching) {
            switching = false;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[1];
                y = rows[i + 1].getElementsByTagName("td")[1];
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
    </script>
    <!-- <script src="../../js/script.js"></script> -->
</body>

</html>
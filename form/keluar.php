<?php

// include "../dashboard/admin/Admin_Controller.php";
session_start();

// $admController = new Admin_Controller();

if (isset($_GET)){
    
    if ($_GET['keluar'] == "true"){
        // $admController->sesstime(intval($_SESSION['id_akun']), "offline");
        session_destroy();
        header("location:../index.php");
        exit;
    }
}
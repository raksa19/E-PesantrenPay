<?php

require_once "Admin_Controller.php";

$admController = new Admin_Controller();

$respon = $admController->buatAkunSiswa($_POST);

if ($respon['status']){
    echo json_encode($respon);
}
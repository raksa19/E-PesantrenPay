<?php

$conn = mysqli_connect("localhost", "root", "", "epayschool");
$requestPayload = file_get_contents('php://input');
$object = json_decode($requestPayload, true);

$nis = $object['nis'];

$fname = $object['fname'];
$lname = $object['lname'];

$nama = strtoupper($fname." ".$lname);

$email = $object['email'];
$address = $object['address'];
$city = $object['city'];
$no_hp = $object['no_hp'];

$q_update_p = mysqli_query($conn, "update data_siswa s inner join akun a on s.id_akun=a.id_akun set 
    s.nama='$nama',
    a.email='$email',
    s.alamat='$address',
    s.kota='$city',
    s.no_hp='$no_hp' where s.nis='$nis'");

    if ($q_update_p){
        echo "Berhasil update data siswa.";
    }
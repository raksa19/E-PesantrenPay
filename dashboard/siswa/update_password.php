<?php

$conn = mysqli_connect("localhost", "root", "", "epayschool");

$id_user = $_POST['id_user'];
$passwd = $_POST['new_pass'];

if (isset($id_user)){
    $q_update_pw = mysqli_query($conn, "update akun a inner join data_siswa s 
    on a.id_akun=s.id_akun set passwd='$passwd' where s.nis='$id_user' or a.email='$id_user'");
    if ($q_update_pw){
        echo "berhasil ubah password !";
    }
}
// else{
//     $q_update_pw = mysqli_query($conn, "update akun set passwd='$passwd' where email='$id_user'");
//     if ($q_update_pw){
//         echo "berhasil ubah password !";
//     }
// }


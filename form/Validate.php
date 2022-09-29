<?php

require_once "config/Config.php";

// session_start();

class Validate extends Config{


    function login(array $data){
        $user_id = $data['userId'];
        $user_pass = $data['userPasswd'];
    
        if ($user_id != null && $user_pass != null) {
            $q_select = Config::$mysql->query("select a.id_akun, l.nm_akses, 
            a.email, a.passwd, s.nama as snama, ad.nama as adnama from akun a 
            inner join level_user l on a.id_level=l.id_level 
            left join data_siswa s on s.id_akun=a.id_akun 
            left join data_admin ad on ad.id_akun=a.id_akun where a.email='$user_id'");
    
            $rows = $q_select->fetch_assoc();
            if ($rows) {
                if ($user_pass === $rows['passwd']){
                    $_SESSION['login'] = $rows['nm_akses'];
                    $_SESSION['email'] = $rows['email'];
                    $_SESSION['id_akun'] = $rows['id_akun'];
                    // $stauts = $admController->sesstime(intval($rows['id_akun']), "online");
                    
                    if ($rows['nm_akses'] == "admin"){
                        header("location:dashboard/admin/");
                        return array(
                            'status' => true, 
                            'message' => "Selamat Datang ".strtoupper($rows['adnama']), 
                            'akses' => $rows['nm_akses']
                        );
                    }else{
                        header("location:dashboard/siswa/");
                        return array(
                            'status' => true, 
                            'message' => "Selamat Datang ".strtoupper($rows['snama']), 
                            'akses' => $rows['nm_akses']
                        );
                    }
    
                    
                }else{
                    return array(
                        'status' => false, 
                        'message' => 'password salah!',
                        'pesan_code' => 201
                    );
                }
                
            }elseif (!$rows > 0){
                return array(
                    'status' => false, 
                    'message' => 'Username atau password salah!',
                    'pesan_code' => 201
                );
            }
            else {
                return array(
                    'status' => false, 
                    'message' => "Akun belum dibuat <a href='../index.php'>kembali</a>",
                    'pesan_code' => 407
                );
            }
        }
    }
}
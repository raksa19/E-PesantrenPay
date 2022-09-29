<?php

$conn = mysqli_connect("localhost", "root", "", "epayschool");

$kelas = $_POST['kelas'];
$q_select_s = mysqli_query($conn, "select nis, nama from data_siswa s 
inner join kelas k on s.id_kelas=k.id_kelas where k.kelas='$kelas'");


if (isset($_POST)) {
    
    while($rows = mysqli_fetch_assoc($q_select_s)){
        $id_tagihan = explode("31300", strval($rows['nis']), 2)[1] . rand(100, 200);
        $nis = intval($rows['nis']);
        $nm_tagihan = $_POST['nmtagihan'];
        $waktu_dibuat = $_POST['waktudibuat'];
        
        if (isset($_POST['jml-cil'])) {
            for ($i = 1; $i <= intval($_POST['jml-cil']); $i++) {
                $nominal = $_POST["nom$i"];
                if (preg_match("/^[a-zA-Z\s0-9]+$/", $nm_tagihan)) {
                    $nm_tagihan = preg_replace("/\d+/u", "", $nm_tagihan) . "$i";
                    $id_tagihan = intval($id_tagihan . $i);

                    // echo json_encode(array('nis' => $rows['nis'], 'nama' => $rows['nama'], 'id_tag' => $id_tagihan, 'nominal' => $nominal));
                    $query_insert = mysqli_query($conn, "insert into tagihan (id_tagihan, nis, nm_tagihan, nominal, waktu_dibuat) values 
                        ('$id_tagihan', '$nis', '$nm_tagihan', '$nominal', '$waktu_dibuat')");
                    if ($query_insert) {
                            echo "Berhasil mengirimkan tagihan!";
                        }
                    }
                }
            } else {
                $nominal = $_POST['nominal'];
                // echo json_encode(array('nis' => $rows['nis'], 'nama' => $rows['nama'], 'id_tag' => $id_tagihan, 'nominal' => $nominal));
                $query_insert = mysqli_query($conn, "insert into tagihan (id_tagihan, nis, nm_tagihan, nominal, waktu_dibuat) values 
                    ('$id_tagihan', '$nis', '$nm_tagihan', '$nominal', '$waktu_dibuat')");
        
                if ($query_insert) {
                    echo "Berhasil mengirimkan tagihan!";
                }
        }
    }
}
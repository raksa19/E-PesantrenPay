<?php

$conn = mysqli_connect("localhost", "root", "", "epayschool");
$id_tr = $_POST['id_transaksi'];

$q_select = mysqli_query($conn, "select *, tr.nominal as trnom from transaksi tr 
inner join tagihan t on tr.id_transaksi=t.id_transaksi 
inner join data_siswa s on tr.nis=s.nis 
inner join kelas k on s.id_kelas=k.id_kelas where tr.id_transaksi='$id_tr'");

$data = array();

if ($q_select){
    $rows = mysqli_fetch_assoc($q_select);
    $data['nis'] = $rows['nis'];
    $data['semester'] = $rows['semester'];
    $data['kelas'] = $rows['kelas'];
    $data['nama'] = $rows['nama'];
    $data['id_transaksi'] = $rows['id_transaksi'];
    $data['order_id'] = $rows['order_id'];
    $data['trnom'] = $rows['trnom'];
    $data['nm_tagihan'] = $rows['nm_tagihan'];
    $data['status_tr'] = $rows['status_tr'];
    $data['status_code'] = $rows['status_code'];
    $data['payment_type'] = $rows['payment_type'];
    $data['va_number'] = $rows['va_number'];
    $data['periode'] = date_format(date_create($rows['waktu_dibuat']), "Y")." ".$rows['semester'];
    $data['tr_time'] = date_format(date_create($rows['tr_time']), "d - M - Y");

}

echo json_encode($data);
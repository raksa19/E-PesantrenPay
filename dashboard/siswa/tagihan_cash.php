<?php

require_once "Siswa_Controller.php";

$siswaController = new Siswa_Controller();

if (isset($_POST)){

    $status_query = array();
    $no_index = 0;

    foreach ($_POST['item_details'] as $item_detail){
        $query = "insert into transaksi (id_transaksi, order_id, nis, nominal, status_tr, status_code, payment_type) 
        values ('".$item_detail['id']."', '".$item_detail['id']."', '".$_POST['nis']."', '".$item_detail['price']."', 
        'pending', '201', 'cash')";

        if ($siswaController->db->query($query)){
            $status_query[$no_index++] = $siswaController->db->query("update tagihan set id_transaksi='".$item_detail['id']."' 
            where id_tagihan='".$item_detail['id']."'");
        }

    }   

    if (in_array(true, $status_query)){
        echo json_encode([
            'status' => true,
            'pesan' => 'Berhasil dibuat.'
        ]);
    }
}
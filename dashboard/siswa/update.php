<?php
require_once "Siswa_Controller.php";
session_start();

$siswaController = new Siswa_Controller();
// $requestPayload = file_get_contents('php://input');
if (isset($_POST)) {

    $nis = $_POST['nis'];
    $result = $_POST['result'];
    $token = $_POST['token'];
    $id_tagihan = $_POST['id_tag'];


    $status_code = $result['status_code'];
    $order_id = intval($result['order_id']);
    $transaksi_id = $result['transaction_id'];
    $gross_amount = intval($result['gross_amount']);
    $py_type = $result['payment_type'];
    $tr_time = $result['transaction_time'];
    $tr_status = $result['transaction_status'];
    $bank = $result['va_numbers'][0]['bank'];
    $va_number = $result['va_numbers'][0]['va_number'];

    for ($i = 0; $i < count($id_tagihan); $i++) {
        $d = $id_tagihan[$i];
        $q_insert_tr = $siswaController->db->query("insert into transaksi (id_transaksi, order_id, nis, nominal, token, status_tr, status_code, payment_type, va_number, bank, tr_time) 
    values ('$transaksi_id', '$order_id', '$nis', '$gross_amount', '$token', '$tr_status', '$status_code', '$py_type', '$va_number', '$bank', '$tr_time')");
        $q_update_t = $siswaController->db->query("update tagihan set id_transaksi='$transaksi_id' where id_tagihan='$d'");
        if ($q_insert_tr && $q_update_t) {
            echo json_encode([
                'status' => true,
                'pesan' => "query ke tb transaksi berhasil"
            ]);
        }
    }

}

$siswaController->db->close();
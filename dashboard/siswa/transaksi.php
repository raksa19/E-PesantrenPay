<?php
$conn = mysqli_connect("localhost", "root", "", "epayschool");
$requestPayload = file_get_contents('php://input');
$object = json_decode($requestPayload, true);
$nis = $object['nis'];
$q_select = mysqli_query($conn, "select * from transaksi where nis='$nis'");

$data = array();

if ($q_select){
    $rows = mysqli_fetch_assoc($q_select);

    for($i=0; $i < mysqli_num_rows($q_select); $i++){
        $data[$i] = array('id_tran' => $rows[$i]['id_transaksi'],
        'id_tag' => $rows[$i]['id_tagihan'],
        'nis' => $rows[$i]['nis'],
        'nm_tag' => $rows[$i]['nm_tagihan'],
        'token' => $rows[$i]['token'],
        'status_tr' => $rows[$i]['status_tr'],
        'status_cd' => $rows[$i]['status_code'],
        'pay_type' => $rows[$i]['payment_type'],
        'bank' => $rows[$i]['bank'],
        'tr_time' => $rows[$i]['tr_time']);
    }
}

echo json_encode($data);
<?php
require_once "Admin_Controller.php";

$admController = new Admin_Controller();

$curl = curl_init();

$server_key = "SB-Mid-server-FtctbZ-K_ECETtO6-2j-Eb4e";

while(true){
    try{
        $q_select = $admController->db->query("select id_transaksi from transaksi where payment_type='bank_transfer'");

        if ($q_select){
            while($id_transaksi = $q_select->fetch_assoc()){
                $id = $id_transaksi['id_transaksi'];
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.sandbox.midtrans.com/v2/'.$id.'/status',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Basic '.base64_encode($server_key . ':')
                  ),
                ));
                
                $response = json_decode(curl_exec($curl), true);
                
                curl_close($curl);
                
                $st_code = $response['status_code'];
                $st_transaksi = $response['transaction_status'];
                $settlement_time = "";
                if (isset($response['settlement_time'])){
                    $settlement_time = $response['settlement_time'];
                }
    
                // echo $st_code."\n";
                // echo $st_transaksi."\n";
                // echo $settlement_time."\n";
                // echo $id."\n";
                echo "cek.!\n";
                $q_update = $admController->db->query("update transaksi set status_code='$st_code', status_tr='$st_transaksi', 
                tr_time='$settlement_time' where id_transaksi='$id'");
                
                if ($q_update){
                    echo "Berhasil meng update status\n";
                }
            }
        }
    }
    catch(Exception $e){
        echo $e;
    }
    sleep(5);
}

$admController->db->close();
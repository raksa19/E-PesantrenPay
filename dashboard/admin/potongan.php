<?php

require_once "Admin_Controller.php";

$admController = new Admin_Controller();


    if(isset($_POST)){
        $id_tag = intval($_POST['id']);
        $pot = intval($_POST['pot1']) + intval($_POST['pot2']);

        $q_select_t = $admController->db->query("select t.nm_tagihan, t.nominal as tnom, tr.status_tr from tagihan t left join transaksi tr on t.id_transaksi=tr.id_transaksi where t.id_tagihan='$id_tag'");

        if ($q_select_t){
            $row = $q_select_t->fetch_assoc();
            $nom = intval($row['tnom']) - $pot;
            if ($row['status_tr'] != "done" || $row['status_tr'] != "cencel" || $row['status_tr'] != "pending"){
                $q_update_t = $admController->db->query("update tagihan set nominal='$nom' where id_tagihan='$id_tag'");
                if($q_update_t){
                    echo "potongan berhasil";
                }
            }
            else{
                echo "tidak bisa di update karena status sudah berubah";
            }
        }else{
            echo "not ok ";
        }

        // var_dump($pot."\n".$id_tag);
    }
?>
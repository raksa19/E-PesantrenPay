<?php

require_once "../../config/Config.php";

class Siswa_Controller extends Config{

    public $db;

    function __construct()
    {
        // $this->db = new Config("localhost", "root", "", "epayschool");
        $mysqli = new mysqli($this->host, $this->user, $this->passwd, $this->defaultdb);

        // Check connection
        if ($mysqli->connect_errno) {
            return "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        $this->db = $mysqli;
    }

    function ambilPesan(int $nis){

        $result = array();
        $no_index = 0;

        $query_1 = "select message, baca from message where nis_to = 0 or nis_to = $nis";
        $fungsi_query = $this->db->query($query_1);

        if ($fungsi_query->num_rows > 0){
            // $result['notif'] = $fungsi_query->fetch_assoc()['notif'];

            while($data = $fungsi_query->fetch_assoc()){
                $result[$no_index++] = $data;
            }
        }

        return array('msg' => $result, 'notif' => $fungsi_query->num_rows);
    }

    function updateDataSiswa(array $data, int $userID){

        $keys = array_keys($data);
        $result = array();

        for ((int) $i=0; $i < sizeof($keys); $i++){
            if ($data[$keys[$i]] != null){
                $query = "update data_siswa set ".$keys[$i]."='".$data[$keys[$i]]."' where nis=".$userID;
                $result[0] = $this->db->query($query);
            }
        }

        return array('status' => $result, 'pesan' => 'Berhasil update data.');
    }


}
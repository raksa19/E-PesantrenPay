<?php

include "../../vendor/autoload.php";
require_once "../../config/Config.php";

class Admin_Controller extends Config
{

    public $db;
    public $pesan;
    protected $filterByStatus = ['200'];
    protected $showlimit = [5];

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

    public function dataUserAkun(string $userID)
    {
        //query select tb data_siswa dan tb kelas
        $q_select_s = $this->db->query("select * from data_admin sa  
        inner join akun a on sa.id_akun=a.id_akun 
        inner join level_user l on a.id_level=l.id_level where a.email='$userID'");

        if ($q_select_s){
            return array(
                'status' => true,
                'data' => $q_select_s->fetch_assoc()
            );
        }
    }

    public function editDataSiswa(array $data, int $userID)
    {

        $keys = array_keys($data);
        $result = array();

        for ((int) $i = 0; $i < sizeof($keys); $i++) {
            if (!empty($data[$keys[$i]])) {
                $query = "update data_siswa set " . $keys[$i] . "='" . $data[$keys[$i]] . "' where nis=$userID";
                $result[$keys[$i]] = $this->db->query($query);
            }
        }

        return array(
            'status' => true,
            'pesan' => 'Berhasil di perbarui.',
            'data' => $result
        );
    }

    public function ambilDataSiswa(int $userID)
    {

        $userID = is_numeric($userID) ? intval($userID) : $userID;
        $query = "select s.nama, k.kelas, s.semester, s.nis, s.jenis_kelamin, s.waktu_masuk,
        s.alamat, s.kota, s.no_hp, s.nm_no, a.email from data_siswa s inner join kelas k on s.id_kelas=k.id_kelas 
        left join akun a on s.id_akun=a.id_akun where nis like '$userID' or s.nama like '$userID'";

        $result = $this->db->query($query)->fetch_array();

        if (!empty($result)) {
            return $result;
        }
    }

    public function buatTagihan(array $data, bool $perSiswa = false)
    {

        $keys = array_keys($data);
        $result = array();

        //query untuk mengambil nim semua dari tabel data_siswa
        $fungsi_query = $this->db->query("select s.nis from data_siswa s inner join kelas k on s.id_kelas=k.id_kelas where k.kelas='" . $data[$keys[0]]['kelas'] . "'");
        $no_index = 0;
        
        
        if ($perSiswa){
            for ($i=0; $i < sizeof($data); $i++){
                $id_tagihan = explode("31300", strval($data[$keys[$i]]['nis']), 2)[1] . rand(100, 200);
                $query = "insert into tagihan (id_tagihan, nis, nm_tagihan, nominal, waktu_dibuat) values ";
                $query .= "('$id_tagihan', '".$data[$keys[$i]]['nis']."', '" . $data[$keys[$i]]['nm_tagihan'] . "', 
                '" . $data[$keys[$i]]['nominal'] . "', '" . $data[$keys[$i]]['waktu_dibuat'] . "')";
                $result[$i] = $this->db->query($query);
            }

            if (sizeof($result) === sizeof($data) && in_array(true, $result)){
                return array(
                    'status' => true,
                    'pesan' => 'Tagihan Berhasil dibuat.',
                    'data' => $data[$keys[0]]['nis']
                );
            }else{
                return array(
                    'status' => false,
                    'pesan' => 'Tagihan gagal dibuat.',
                    'data' => null
                );
            }

        }else{
            while ($getNis = $fungsi_query->fetch_assoc()){
                for ($i=0; $i < sizeof($data); $i++){
                    $id_tagihan = explode("31300", strval($getNis['nis']), 2)[1] . rand(100, 200);
                    $query = "insert into tagihan (id_tagihan, nis, nm_tagihan, nominal, waktu_dibuat) values ";
                    $query .= "('$id_tagihan', '".$getNis['nis']."', '".$data[$keys[$i]]['nm_tagihan']."', 
                    '".$data[$keys[$i]]['nominal']."', '".$data[$keys[$i]]['waktu_dibuat']."')";
                    $result[$no_index++] = $this->db->query($query);
                }
            }


            if ($fungsi_query->num_rows === sizeof($data)){
                return array(
                    'status' => true,
                    'pesan' => 'Tagihan Berhasil dibuat.',
                    'data' => null
                );
            }else{
                return array(
                    'status' => false,
                    'pesan' => 'Tagihan gagal dibuat.',
                    'data' => null
                );
            }
        }

    }

    function tbDataSiswa(array $katakunci=null, int $halaman = 10, int $mulai = 0)
    {

        $TempData = array();
        $semester = isset($katakunci['semester']) ? $katakunci['semester'] : null;
        $kelas = isset($katakunci['kelas']) ? $katakunci['kelas'] : null;
        $keyword = !empty($katakunci['keyword']) ? "%" . $katakunci['keyword'] . "%" : null;

        $query = "select s.nama, k.kelas, s.jenis_kelamin, s.semester, s.waktu_masuk, s.no_hp, s.nis, s.ttl, a.status as stakun 
        from data_siswa s inner join kelas k on s.id_kelas=k.id_kelas left join akun a on s.id_akun=a.id_akun";
        $total_row = $this->db->query($query);

        if (!empty($katakunci)){
            
            $query .=  " where s.nama like '$keyword' 
            or s.nis like '$keyword' 
            or k.kelas like '$kelas' 
            or s.semester like '$semester'";
        }

        $query .= " order by k.kelas asc limit $halaman offset $mulai";
        $result = $this->db->query($query);

        $no_index = 0;
        if ($result) {
            while ($data = $result->fetch_assoc()) {
                $TempData[$no_index++] = $data;
            }
        }
        return array('data' => $TempData, 'status' => true, 'total_row' => $total_row->num_rows);

    }

    function ambilDataAngkatan()
    {
        $result = array();
        $no_index = 0;

        $query = $this->db->query("select distinct s.waktu_masuk, k.id_kelas, k.kelas from data_siswa s 
        inner join kelas k on s.id_kelas=k.id_kelas where k.kelas in (7,8,9)");
        while ($angkatan = $query->fetch_assoc()) {
            $result[$no_index++] = $angkatan;
        }

        return $result;
    }

    function ubahKelas(array $data)
    {

        $angkatan = isset($data['angkatan']) ? $data['angkatan'] : null;
        $kelas = isset($data['updatekelas']) ? $data['updatekelas'] : null;
        $nis = isset($data['nis']) ? $data['nis'] : null;
 
        $query = $this->db->query("update data_siswa s inner join kelas k on s.id_kelas=k.id_kelas 
        set s.id_kelas=" . intval($kelas) . " where s.nis = $nis and s.waktu_masuk like '%$angkatan%'");

        if ($query) {
            return array('pesan' => 'Berhasil diupdate', 'status' => true);
        }
    }

    function ambilDetail(string $id_tr)
    {
        $query = $this->db->query("select s.nis, s.semester, k.kelas, tr.nominal as trnom, 
        s.nama, t.id_transaksi, tr.order_id, t.nm_tagihan, tr.status_tr, tr.status_code, 
        tr.payment_type, tr.va_number, tr.tr_time, t.id_tagihan from transaksi tr 
        inner join tagihan t on tr.id_transaksi=t.id_transaksi 
        inner join data_siswa s on tr.nis=s.nis 
        inner join kelas k on s.id_kelas=k.id_kelas where tr.id_transaksi='$id_tr'");

        if ($query->num_rows > 0) {
            return array('data' => $query->fetch_assoc(), 'pesan' => 'Data ada.', 'status' => true);
        }
    }

    function ambilJumlahData(string $data)
    {

        //variable query
        $query = null;

        if ($data === "SISWA") {
            $query = "select count(s.nis) as jml from data_siswa s inner join kelas k 
            on s.id_kelas=k.id_kelas where k.kelas in (7, 8, 9)";
        } elseif ($data === "USER_SISWA") {
            $query = "select count(s.nis) as jml from data_siswa s inner join akun a on s.id_akun=a.id_akun";
        } elseif ($data === "SISWA_PEREMPUAN") {
            $query = "select count(jenis_kelamin) as jml from data_siswa where jenis_kelamin='perempuan'";
        } elseif ($data === "SISWA_LAKI") {
            $query = "select count(jenis_kelamin) as jml from data_siswa where jenis_kelamin='laki'";
        } elseif ($data === "200") {
            $query = "select count(status_code) as jml from transaksi where status_code='200'";
        } elseif ($data === "201") {
            $query = "select count(status_code) as jml from transaksi where status_code='201'";
        } elseif ($data === "407") {
            $query = "select count(status_code) as jml from transaksi where status_code='407'";
        }

        $fungsi_query = $this->db->query($query);

        if ($fungsi_query->num_rows > 0) {
            return $fungsi_query->fetch_assoc()['jml'];
        }
    }

    function dataSiswaPerTahun()
    {

        $data = array();
        $no_index = 0;
        $query = "select count(nis) as jsiswa, waktu_masuk as tmasuk from data_siswa group by waktu_masuk";
        $fungsi_query = $this->db->query($query);

        if ($fungsi_query->num_rows > 0) {
            while ($row = $fungsi_query->fetch_array()) {
                $data[$no_index++] = $row;
            }
        }
        return $data;
    }

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    function tbIncome(bool $income = false, int $page = 5, int $offset = 0)
    {
        $data = array();
        $no_index = 0;
        $query = null;

        if ($income) {
            $query = "select *, tr.nominal as trnom from transaksi tr 
            inner join tagihan t on tr.id_transaksi=t.id_transaksi
            inner join data_siswa s on tr.nis=s.nis 
            inner join kelas k on s.id_kelas=k.id_kelas limit $page offset $offset";
        } else {
            $query = "select count(id_transaksi) as total from transaksi";
        }

        $fungsi_query = $this->db->query($query);

        if ($fungsi_query->num_rows > 0) {
            while ($row = $fungsi_query->fetch_assoc()) {
                $data[$no_index++] = $row;
            }
        }

        return $data;
    }

    function dataIncome(bool $bulanan = false)
    {
        $data = array();
        $no_index = 0;
        $query = null;

        if ($bulanan) {
            $query = "select count(status_code) as tbulan, tr_time as bulan from transaksi group by month(tr_time)";
        } else {
            $query = "select count(status_code) as ttahun, year(tr_time) as tahun from transaksi group by year(tr_time) is not null";
        }

        $fungsi_query = $this->db->query($query);

        if ($fungsi_query->num_rows > 0) {
            while ($row = $fungsi_query->fetch_array()) {
                $data[$no_index++] = $row;
            }
        }
        return $data;
    }

    function kirimPesan(array $data)
    {

        $id_msg = rand(1000, 5000);
        $messege = isset($data['pesan']) ? $data['pesan'] : null;
        $id_from = ($data['id_from'] == "all") ? "all" : $data['id_from'];
        $id_to = ($data['id_to'] == "all") ? "all" : $data['id_to'];
        $to_user = ($data['to_user'] == "all") ? "all" : $data['to_user'];
        $from_user = ($data['from_user'] == "all") ? "all" : $data['from_user'];

        $query = "insert into message values 
        ($id_msg, '$from_user', $id_from, '$to_user', $id_to, '$messege', '0')";

        $fungsi_query = $this->db->query($query);

        if ($fungsi_query) {
            return array('data' => $fungsi_query, 'pesan' => 'Pesan berhasil disimpan.');
        }
    }

    function ambilPesan(int $nis)
    {
        $notif = 0;
        $data = array();

        $query = "select count(id_msg) as notif, message from message where nis_to=0";
        $fungsi_query = $this->db->query($query);

        if ($fungsi_query->num_rows > 0) {
            $notif = $fungsi_query->fetch_assoc()['notif'];
        }

        $ambil_pesan = $this->db->query("select * from message where nis_from=$nis");
        if ($ambil_pesan){
            $no_index = 0;
            while($dataMsg = $ambil_pesan->fetch_assoc()){
                $data['id_msg '.$no_index++] = [
                            'nis_to' => $dataMsg['nis_to'],
                            'user_to' => $dataMsg['to_user'],
                            'msg' => $dataMsg['message'],
                ];
            }
        }

        return array('data' => $data, 'notif' => $fungsi_query);
    }

    function updateDataAdmin(array $data, int $userID)
    {
        $keys = array_keys($data);
        $result = false;
        $data_update = array();

        for ((int) $i = 0; $i < sizeof($keys); $i++) {
            if ($data[$keys[$i]] != null) {
                $query = "update data_admin s inner join akun a on s.id_akun=a.id_akun set "; 
                
                if ($keys[$i] == "email" || $keys[$i] == "passwd"){
                    $query .= "a.".$keys[$i] . "='" . $data[$keys[$i]] . "' where nis=" . $userID;
                }else{
                    $query .= "s.".$keys[$i] . "='" . $data[$keys[$i]] . "' where nis=" . $userID;
                }
                $data_update = $keys[$i]." ".$data[$keys[$i]];
                $result = $this->db->query($query);
            }
        }
        if ($result){
            return array('pesan' => 'Berhasil update data.', 'status' => true, 'data' => $data_update);
        }
    }

    function dataReport(array $data, int $limit, int $offset=0)
    {

        $result = array();

        $query = "select t.id_tagihan, tr.id_transaksi, s.nis, s.nama, k.kelas, t.nm_tagihan, 
        t.nominal, t.waktu_dibuat, tr.tr_time, tr.status_code from data_siswa s 
        inner join kelas k on s.id_kelas=k.id_kelas 
        left join tagihan t on s.nis=t.nis 
        left join transaksi tr on t.id_tagihan=tr.order_id";
        
        $total_row = $this->db->query("select count(id_transaksi) as total 
        from transaksi")->fetch_assoc()['total'];

        if ($data['filterbykelas'] != null) {
            $query .= " where s.id_kelas='" . $data['filterbykelas'] . "'";
        }

        if (!empty($data['status'])){
            $inQuery = null;
            $this->filterByStatus = $data['status'];
            for ($i=0; $i < sizeof($data['status']); $i++){
                $inQuery .= $data['status'][$i].", ";
            }
            if ($data['status'] != null && $data['filterbykelas'] != null){
                $query .= " or tr.status_code in (".substr($inQuery, 0, -2).")";
            }else{
                $query .= " where tr.status_code in (".substr($inQuery, 0, -2).")";
            }
        }

        $query .= " limit $limit offset $offset";

        $fungsi_query = $this->db->query($query);
        $no_index = 0;

        if ($fungsi_query) {
            while ($data = $fungsi_query->fetch_assoc()) {
                $result[$no_index++] = $data;
            }
        }

        return array(
            'status' => true, 
            'data' => $result, 
            'q' => $query, 
            'filter' => $this->filterByStatus, 
            'total_row' => intval($total_row)
        );
    }

    function tambahDataSiswa(array $data)
    {

        $query = "insert into data_siswa (nis, id_kelas, nama, semester, jenis_kelamin, ttl, waktu_masuk, kota, no_hp, nm_no, alamat) 
        values ('" . $data['nis'] . "', '" . $data['id_kelas'] . "', '" . $data['nama'] . "', '" . $data['semester'] . "', '" . $data['jenis_kelamin'] . "', 
        '" . $data['ttl'] . "', '" . $data['waktu_masuk'] . "', '" . $data['kota'] . "', '" . $data['no_hp'] . "', '" . $data['nm_no'] . "', '" . $data['alamat'] . "')";

        $fungsi_query = $this->db->query($query);

        if ($fungsi_query) {
            return array('status' => true, 'pesan' => 'Data Siswa Berhasil di Tambahkan.');
        }
    }

    function buatAkunSiswa(array $data)
    {
        
        $id_akun = intval(explode("31300", $data['nis'])[1] . preg_replace("/\D+/", "", $data['ttl']));
        $id_level = 2;
        $user = explode(" ", strtolower($data['nama']))[0] . "@" . explode(" ", strtolower($data['nama']))[1];
        $passwd = "12345@";
        $get_date = getdate();
        $waktu_dibuat = "$get_date[year]-$get_date[mon]-$get_date[mday]";

        $query_insert_akun = "insert into akun (id_akun, id_level, email, passwd, waktu_dibuat) 
        values ('$id_akun', '$id_level', '$user', '$passwd', '$waktu_dibuat')";

        if ($this->db->query($query_insert_akun)){
            $update_idakun = $this->db->query("update data_siswa set id_akun='$id_akun' where data_siswa.nis='".$data['nis']."'");

            if ($update_idakun){
                return array('data' => $user, 'pesan' => 'Akun berhasil dibuat.', 'status' => true);
            }
        }

    }

    function sesstime($id_akun, $status){
        $timestamp = date("Y-m-d H:i:s");
        $id_akun = intval($id_akun);
        
        if ($status === "online"){
            $q_update = $this->db->query("update akun set logged_in='$timestamp', status='$status' where id_akun='$id_akun'");
        
            if ($q_update){
                return $status." ok!";
            }
        }else{
            $q_update = $this->db->query("update akun set logged_out='$timestamp', status='$status' where id_akun='$id_akun'");
        
            if ($q_update){
                return $status." ok!";
            }
    
        }
    }

    function importDataDatabase(array $data){

        $namaFile = $data['namafile'];
        $extFile = explode('.', $data['namafile']);
        $nm_tabel = $data['namatabel'];
        $index_of = array();
        $no_urut = 1;
        $no_index = 0;

        if (end($extFile) == 'xls'){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }else{
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load('./uploads/'.$namaFile)->getActiveSheet()->toArray();

        foreach ($spreadsheet as $key => $value){
            
            if ($value != null){
                $index_of['no'] = array_search('no', $value);
                $index_of['id_kelas'] = array_search('id_kelas', $value);
                $index_of['nama'] = array_search('nama', $value);
                $index_of['semester'] = array_search('semester', $value);
                $index_of['jenis_kelamin'] = array_search('jenis_kelamin', $value);
                $index_of['ttl'] = array_search('ttl', $value);
                $index_of['waktu_pendaftaran'] = array_search('waktu_pendaftaran', $value);
                $index_of['kota'] = array_search('kota', $value);
                $index_of['no_hp'] = array_search('no_hp', $value);
                $index_of['nm_no'] = array_search('nm_no', $value);
                $index_of['alamat'] = array_search('alamat', $value);
                break;
            }

        }

        foreach($spreadsheet as $key => $value){
            if ($key == 0){
                continue;
            }
            if ($value[$index_of['no']] != null){
                $duaDigitTahun = substr(date_format(date_create($value[$index_of['ttl']]), "Y"), 2);
                $no_urutSiswa = sprintf('%03d', $no_urut++);
                
                $query = $this->db->query("insert into $nm_tabel (nis, id_kelas, nama, semester, jenis_kelamin, ttl, waktu_masuk, kota,
                no_hp, nm_no, alamat) values ('".$duaDigitTahun."26363".$no_urutSiswa."', 
                '".$value[$index_of['id_kelas']]."', '".$value[$index_of['nama']]."', 
                '".$value[$index_of['semester']]."', '".$value[$index_of['jenis_kelamin']]."', 
                '".date_format(date_create($value[$index_of['ttl']]), "Y-m-d")."', '".date_format(date_create($value[$index_of['waktu_pendaftaran']]), "Y-m-d")."',
                '".$value[$index_of['kota']]."', 
                '".$value[$index_of['no_hp']]."', '".$value[$index_of['nm_no']]."', 
                '".$value[$index_of['alamat']]."')");
            }
        }

        if ($query){
            unlink('./uploads/'.$namaFile);
            return array('status' => true, 'pesan' => 'Berhasil input data ke Database');
        }
    }

    function tbtagihan(int $limit, int $offset=0, String $search){

        $result = array();
        $query = "select t.nm_tagihan, t.nominal, tr.payment_type, tr.status_code, t.id_tagihan, t.id_transaksi, t.nis 
        from tagihan t left join transaksi tr 
        on tr.id_transaksi=t.id_transaksi";
        
        if (!empty($search)){
            $query .= " where t.nis like '%".$search."%' or tr.id_transaksi like '%".$search."%'";
        }
        
        // $limit = ($limit > 5) ? $this->showlimit[0] = $limit : 5;
        $query .= " limit ".$limit." offset $offset";
        $query_py = $this->db->query($query);
        $total_row = $this->db->query("select count(id_tagihan) as total_tagihan from tagihan")->fetch_assoc();
        if ($query_py){
            $no_index = 0;
            while ($data = $query_py->fetch_assoc()){
                $result[$no_index++] = $data;
            }
            
            return array(
                'data' => $result, 
                'status' => true, 
                'total_row' => $total_row['total_tagihan'],
                'last_show' => $this->showlimit
            );
        } 

    }

    function bayarCash(array $data){

        $query_insert_transaksi = "insert into transaksi values ('".$data['id_tagihan']."', '".$data['id_tagihan']."', 
        '".$data['nis']."', '".$data['nominal']."', '', 'settlement', '200', 'cash', '', '', '".date("Y-m-d H:i:s")."')";

        if ($this->db->query($query_insert_transaksi)){
            $query = "update tagihan set id_transaksi=".$data['id_tagihan']." where id_tagihan=".$data['id_tagihan']."";
    
            if ($this->db->query($query)){
                return array(
                    'status' => true,
                    'pesan' => 'Pembayaran Tagihan Berhasil, Status Lunas'
                );
            }
        }
    }

}
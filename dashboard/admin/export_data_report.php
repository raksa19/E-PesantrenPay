<?php
require_once "Admin_Controller.php";
session_start();

$admController = new Admin_Controller();

// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=Data Report Siswa.xls");

function saved(){
    $file = "Data Report Siswa.xls";
    header('Content-type: application/vnds-ms-excel');
    header('Content-disposition: attachment; filename='.$file);
// header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Length: ' . filesize($file));
// header('Content-Transfer-Encoding: binary');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// ob_clean();
// flush(); 
// readfile($file);
}

$query = isset($_GET['q']) ? $_GET['q'] : null;
$responQuery = $admController->db->query($query);

if ($responQuery){
    $_SESSION['alert'] = "Export Data.";
    echo "<script>window.location.replace('index.php?page=datsiswa&sub=report')</script>";
    saved();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Export Data Transaksi Santri
    </title>
</head>

<body>
    <h1 style="text-align: center;">Data Transaksi Santri</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>ID TAGIHAN</th>
                <th>ID TRANSAKSI</th>
                <th>NIS</th>
                <th>NAMA</th>
                <th>KELAS</th>
                <th>NAMA TAGIHAN</th>
                <th>NOMINAL TAGIHAN</th>
                <th>WAKTU TAGIHAN DIBUAT</th>
                <th>WAKTU TRANSAKSI</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php
      $no = 1;
      foreach ($responQuery as $row) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['id_tagihan'] ?></td>
                <td><?= $row['id_transaksi'] ?></td>
                <td><?= $row['nis'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['kelas'] ?></td>
                <td><?= $row['nm_tagihan'] ?></td>
                <td><?= $row['nominal'] ?></td>
                <td><?= $row['waktu_dibuat'] ?></td>
                <td><?= $row['tr_time'] ?></td>
                <?php if ($row['status_code'] == "200") : ?>
                <td><span class="badge badge-success">Lunas</span></td>
                <?php elseif ($row['status_code'] == "201") : ?>
                <td><span class="badge badge-warning">Pending</span></td>
                <?php elseif ($row['status_code'] == "407") : ?>
                <td><span class="badge badge-danger">Kadaluarsa</span></td>
                <?php endif ?>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>
<?php

require_once "Admin_Controller.php";

session_start();

if ($_SESSION['login'] != "admin") {
    header("location:../../index.php");
    exit;
}

$conn = new Admin_Controller();
$nis = (int)$_GET['id'];
$query = $conn->db->query("select * from data_siswa s inner join kelas k on s.id_kelas=k.id_kelas where nis='$nis'");
$data = $query->fetch_assoc();

$q_tagihan = $conn->db->query("select *, t.nominal as tnom, tr.nominal as trnom from tagihan t 
    left join transaksi tr on t.id_transaksi=tr.id_transaksi where t.nis='$nis'");

$id_tagihan = explode("31300", strval($nis), 2)[1] . rand(100, 200);

if (isset($_POST['submit'])) {
    $nm_tagihan = $_POST['nmtagihan'];
    $waktu_dibuat = $_POST['waktudibuat'];

    if (isset($_POST['jml-cil'])) {
        for ($i = 1; $i <= intval($_POST['jml-cil']); $i++) {
            $nominal = $_POST["nom$i"];
            if (preg_match("/^[a-zA-Z\s0-9]+$/", $nm_tagihan)) {
                $nm_tagihan = preg_replace("/\d+/u", "", $nm_tagihan) . "$i";
                $id_tagihan = intval($id_tagihan . $i);
                $query_insert = $conn->db->query("insert into tagihan (id_tagihan, nis, nm_tagihan, nominal, waktu_dibuat) values 
                    ('$id_tagihan', '$nis', '$nm_tagihan', '$nominal', '$waktu_dibuat')");
            }
        }
    } else {
        $nominal = $_POST['nom'];
        $query_insert = $conn->db->query("insert into tagihan (id_tagihan, nis, nm_tagihan, nominal, waktu_dibuat) values 
            ('$id_tagihan', '$nis', '$nm_tagihan', '$nominal', '$waktu_dibuat')");

        if ($query_insert) {
            header("location:buat_tag.php?id=" . $nis);
        }
    }
}

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

$conn->db->close();
?>
<?php if ($data != null) {

    $tahun_masuk = date_format(date_create($data['waktu_masuk']), "Y");
    $semester = $data['semester'];
    if ($data['semester'] == null) {
        $semester = "Alumni";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../../../mpti/css/fontawesome/all.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <title><?= $data['nama']; ?></title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-sm-3 text-center">
                                <img src="https://sim.unusa.ac.id/siakad/siakad/uploads/fotomhs/<?= $tahun_masuk; ?>/<?= $nis; ?>.jpg?r=94804"
                                    class="card-img rounded" style="width: auto; height: 200px;" alt="...">
                            </div>
                            <div class="col-sm">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="fas fa-user-alt"></i>
                                        <span><?= $data['nama']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-mars"></i>
                                        <span><?= $data['jenis_kelamin']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-home "></i>
                                        <span><?= $data['kota']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="index.php?page=invoice&nis=<?= $nis ?>"
                                            class="btn btn-outline-info btn-sm">Buat Tagihan</a>
                                        <a href="index.php?page=datsiswa"
                                            class="btn btn-outline-warning btn-sm">Kembali</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="fa fa-graduation-cap"></i>
                                        <span><?= $data['kelas']; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-book-reader"></i>
                                        <span><?= $semester; ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-calendar"></i>
                                        <span><?= $tahun_masuk; ?></span>
                                    </li>
                                    <li class="list-group-item"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3 mb-5">
            <!-- <div class="col-sm-auto">
                    <form action="" method="POST">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="nmtagihan" id="nmtagihan" placeholder="Nama tagihan">
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="nom" id="nominaltagihan" placeholder="Nominal tagihan">
                                </div>
                                <div class="input-group mb-2">
                                    <input type="date" class="form-control" name="waktudibuat" id="waktudibuat">
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" onclick="activate_cicilan()" id="act_checkbox" class="form-check-input">
                                    <label class="form-check-label">Bisa di cicil</label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <select id="jumlahcicilan" name="jml-cil" onclick="selectCil()" class="custom-select form-control-sm" disabled>
                                        <option selected>Choose...</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option disabled>Custom</option>
                                    </select>
                                </div>
                                <div class="input-group mb-2 d-none" id="field">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="nom1" placeholder="Nominal tagihan">
                                </div>
                                <div class="input-group mb-2 d-none" id="field">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="nom2" placeholder="Nominal tagihan">
                                </div>
                                <div class="input-group mb-2 d-none" id="field">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="nom3" placeholder="Nominal tagihan">
                                </div>
                                <div class="input-group mb-2 d-none" id="field">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="nom4" placeholder="Nominal tagihan">
                                </div>
                                <input type="submit" class="btn btn-warning float-right" name="submit">
                            </div>
                        </div>
                    </form>
                </div> -->
            <div class="col-sm-auto">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-sm">
                            <thead style="font-weight: normal;">
                                <th>No</th>
                                <th>Nama Tagihan</th>
                                <th>Tagihan</th>
                                <th>Nominal Tagihan</th>
                                <th>Nominal di Bayar</th>
                                <th>Bank</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    require_once "Admin_controller.php";
                                    $admController = new Admin_Controller();

                                    $i = 1;
                                    if ($q_tagihan) {
                                        while ($rows_tr = $q_tagihan->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $rows_tr['nm_tagihan']; ?></td>
                                    <td><?= date_format(date_create($rows_tr['waktu_dibuat']), "d-m-Y"); ?></td>
                                    <td><?= rupiah(intval($rows_tr['tnom'])); ?></td>
                                    <td><?= rupiah(intval($rows_tr['trnom'])); ?></td>
                                    <td><?= ($rows_tr['bank'] != null) ? $rows_tr['bank'] : "-"; ?></td>
                                    <?php
                                                $status = $rows_tr['status_code'];
                                                
                                                $dataOfDetail;

                                                if (isset($rows_tr['id_transaksi'])){
                                                    $responOfDetail = $admController->ambilDetail($rows_tr['id_transaksi']);
                                                    $dataOfDetail = ($responOfDetail['status']) ? $responOfDetail['data'] : null;
                                                }

                                                if ($status == null) {
                                                    echo "<td><span class='badge badge-info'>onProses</span></td>";
                                                } elseif ($status == "200") {
                                                    echo "<td><span class='badge badge-success'>Succes</span></td>";
                                                } elseif ($status == "201") {
                                                    echo "<td><span class='badge badge-warning'>Pending</span></td>";
                                                } elseif ($status == "408") {
                                                    echo "<td><span class='badge badge-danger'>Cenceled</span></td>";
                                                } elseif ($status == "407") {
                                                    echo "<td><span class='badge badge-danger'>Expire</span></td>";
                                                }
                                                ?>
                                    <td class="text-center">
                                        <a href="#" value="<?= $rows_tr['id_tagihan']; ?>"
                                            data-target="#potonganTagihan" data-toggle="modal" id="btn-edit"
                                            <?= ($rows_tr['id_transaksi'] != null) ? 'hidden' : null ?>><i
                                                class="far fa-edit"></i></a>
                                        <a href="#" id="linkdetails"
                                            <?= ($rows_tr['id_transaksi'] == null) ? 'hidden' : null ?>
                                            data-target="#detail" data-toggle="modal"
                                            data-nis="<?= $dataOfDetail['nis'] ?>"
                                            data-nama="<?= $dataOfDetail['nama'] ?>"
                                            data-semester="<?= $dataOfDetail['semester']?>"
                                            data-kelas="<?= $dataOfDetail['kelas']?>"
                                            data-idtagihan="<?= $dataOfDetail['id_tagihan']?>"
                                            data-trtime="<?= $dataOfDetail['tr_time']?>"
                                            data-paymenttype="<?= $dataOfDetail['payment_type']?>"
                                            data-vanumber="<?= $dataOfDetail['va_number']?>"
                                            data-nmtagihan="<?= $dataOfDetail['nm_tagihan']?>"
                                            data-trnom="<?= $dataOfDetail['trnom']?>"
                                            data-statustr="<?= $dataOfDetail['status_tr']?>"><i
                                                class="fas fa-info-circle"></i></a>
                                    </td>
                                </tr>
                                <?php }
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="potonganTagihan" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" id="potongan1" placeholder="Potongan Beasiswa">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" id="potongan2" placeholder="Potongan Prestasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="" id="btn-potongan">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Detail -->
    <div class="modal fade" id="detail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-10">
                            <table class="table table-sm table-responsive-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="text-center">
                                                <img src="../../assets/images/logo.png"
                                                    style="height: 35px; width: 35px;" alt="">
                                            </div>
                                        </td>
                                        <td colspan="3">
                                            <div class="text-center">
                                                <h5 style="font-size:17px;">MTS ABADIYAH GABUS-PATI</h5>
                                                <span style="font-size:11px;">Jl. Tlogoayu - Gabus, Mojolawaran,
                                                    Kuryokalangan, Gabus</span>
                                                <span style="font-size:11px;"> Kabupaten Pati, Jawa Tengah 59173 Telp.
                                                    0813-2551-0284</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <div class="row text-muted mr-4 ml-4 mb-2 justify-content-between" style="font-size: 12px;">
                                <div class="col-md">
                                    <div>
                                        <span>NIS : <span id="nis"></span></span>
                                    </div>
                                    <div>
                                        <span>Nama : <span id="nama"></span></span>
                                    </div>
                                    <div>
                                        <span>Kelas : <span id="kelas"></span></span>
                                    </div>
                                    <div>
                                        <span>Id Tagihan : <span id="id-order"></span></span>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div>
                                        <span>Semester : <span id="semester"></span>
                                    </div>
                                    <div>
                                        <span>Tanggal Pembayaran : <span id="tr-time"></span></span>
                                    </div>
                                    <div>
                                        <span>Payment : <span id="type-payment"></span></span>
                                    </div>
                                    <div>
                                        <span>VA Number : <span id="code-va"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <table class="table table-sm table-bordered table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Tagihan</th>
                                        <th>Periode</th>
                                        <th>Potongan</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px;">
                                    <tr>
                                        <td><span id="nm-tagihan"></span></td>
                                        <td><span id="periode"></span></td>
                                        <td>0</td>
                                        <td>Rp. <span id="nominal"></span></td>
                                        <td><span id="status"></span></td>
                                        <td><a href="" id="cetak"><i class="fas fa-print"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
    var btn_pot = document.querySelector("#btn-potongan");
    var btn_edit = document.querySelectorAll("#btn-edit");

    $(document).ready(function() {
        $(document).on('click', 'a#linkdetails', function() {
            $("#nis").text($(this).data('nis'));
            $("#nama").text($(this).data('nama'));
            $("#kelas").text($(this).data('kelas'));
            $("#id-order").text($(this).data('idtagihan'));
            $("#semester").text($(this).data('semester'));
            $("#tr-time").text($(this).data('trtime'));
            $("#type-payment").text($(this).data('paymenttype'));
            $("#code-va").text($(this).data('vanumber'));
            $("#nm-tagihan").text($(this).data('nmtagihan'));
            $("#nominal").text($(this).data('trnom'));
            $("#status").text($(this).data('statustr'));
        });
    });

    function xhrrequest(method, url, data, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() { // Call a function when the state changes.
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                callback(this.responseText);
            }
        }
        xhr.send(data);

    }

    btn_edit.forEach(function(v, i) {
        v.addEventListener("click", function() {
            var id_tagihan = $(this).attr("value");
            btn_pot.addEventListener("click", function() {
                var potongan1 = document.getElementById("potongan1");
                var potongan2 = document.getElementById("potongan2");

                // data = {id_tag:id_tagihan, pot1:potongan1.value, pot2:potongan2.value};
                var data = "id=" + id_tagihan + "&pot1=" + potongan1.value + "&pot2=" +
                    potongan2.value;
                xhrrequest("POST", "potongan.php", data, function(e) {
                    console.log(e);
                    window.location.reload();
                    $("#div-alert").addClass("show alert-success");
                    $("#div-alert").fadeIn();
                    $("#pesan").html("Berhasil membuat tagihan");
                    setTimeout(function() {
                        $("#div-alert").fadeOut();
                    }, 3000);
                });
                // console.log(data);
                this.setAttribute("data-dismiss", "modal");
            });
        });
    });
    </script>
</body>

</html>
<?php } else {
    echo "<h1>Data Tidak Ada</h1>";
}
?>
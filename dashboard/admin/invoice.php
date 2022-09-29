<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;

$dataUser = array();
(bool) $perSiswa = false;

if (isset($_POST['submit'])) {

    $perSiswa = (isset($_GET['nis'])) ? true : false;
    
    if (isset($_POST['dicicil']) == "on") {
        $diCicil = ($_POST['dicicil'] == "on") ? true : false;
        $jumlahCicilan = $_POST['jumlahCicilan'];
        $no = 0;

        for ((int) $i = 1; $i <= intval($jumlahCicilan); $i++) {
            $dataUser[$no++] = [
                'nm_tagihan' => $_POST['nmtagihan'] . " $i",
                'nominal' => $_POST['nom' . $i],
                'waktu_dibuat' => $_POST['waktu_dibuat'],
                'nis' => isset($_GET['nis']) && is_numeric($_GET['nis']) ? intval($_GET['nis']) : null,
                'kelas' => isset($_POST['kelas']) ? $_POST['kelas'] : null
            ];
        }
    } else {
        $dataUser[0] = [
            'nm_tagihan' => $_POST['nmtagihan'],
            'nominal' => $_POST['nominal'],
            'waktu_dibuat' => $_POST['waktu_dibuat'],
            'kelas' => isset($_POST['kelas']) ? $_POST['kelas'] : null,
            'nis' => isset($_GET['nis']) ? $_GET['nis'] : null
        ];
    }

    $respon = $admController->buatTagihan($dataUser, $perSiswa);

    if ($respon['status']){
        $r = "window.location.replace('index.php?page=invoice";
        if (isset($respon['data'])){
            $r .= '&nis='.$respon['data'];
        }else{
            $r .= null;
        }

        echo $r .= "')";
        $_SESSION['alert'] = $respon['pesan'];
    }
}

//jika tombol bayar ditekan
$responBayar = (isset($_POST['btn-cash'])) ? $admController->bayarCash([
    'nis' => $_POST['nis'],
    'id_tagihan' => intval($_POST['btn-cash']),
    'nominal' => $_POST['nominal']
]) : null;

if (isset($responBayar['status'])){
    echo "<script>window.location.replace('index.php?page=invoice')</script>";
    $_SESSION['alert'] = $responBayar['pesan'];
}

?>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailCash" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mt-3 mb-5">
                    <div class="col-sm-11 mb-2">
                        <div class="row justify-content-center">
                            <div class="col-sm-auto">
                                <table class="table table-sm table-responsive table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="text-center">
                                                    <img src="../../assets/images/logo.png"
                                                        style="height: 35px; width: 35px;" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h5 style="font-size:17px;">MTS ABADIYAH GABUS-PATI</h5>
                                                    <span style="font-size:11px;">Jl. Tlogoayu - Gabus,
                                                        Mojolawaran,
                                                        Kuryokalangan, Gabus</span>
                                                    <span style="font-size:11px;"> Kabupaten Pati, Jawa Tengah
                                                        59173 Telp.
                                                        0813-2551-0284</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row text-muted m-2 mb-2 justify-content-between" style="font-size: 12px;">
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
                        <div class="row justify-content-center">
                            <div class="col-md-auto col">
                                <table class="table table-responsive table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nama Tagihan</th>
                                            <th>Periode Tagihan</th>
                                            <th>Potongan</th>
                                            <th>Tagihan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span id="nm-tagihan"></span></td>
                                            <td><span id="periode"></span></td>
                                            <td>0</td>
                                            <td>Rp. <span id="nominal"></span></td>
                                            <td><span id="status"></span></td>
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
</div>

<!-- Modal Btn Metode Pembayaran -->
<div class="modal fade" id="modalBtnPembayaran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-center text-muted">Metode Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <form action="" method="POST">
                    <input type="text" name="nis" hidden>
                    <input type="text" name="nominal" hidden>
                    <button type="submit" class="btn btn-primary mr-2" name="btn-cash">Cash (Tunai)</button>
                    <button class="btn btn-outline-primary" name="btn-debit">Debit (Debit Card)</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Btn Metode Pembayaran -->

<div class="row">
    <div class="col-sm-auto mb-3">
        <div class="card border-primary">
            <div class="card-header bg-primary"></div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-money-bill-wave">
                                </i></label>
                        </div>
                        <select class="custom-select" name="nmtagihan" id="selectNamaTagihan">
                            <option selected disabled>Nama Tagihan</option>
                            <option value="SPP">SPP</option>
                            <option value="Buku">Buku</option>
                            <option value="Seragam">Seragam</option>
                            <option value="Daftar Ulang">Daftar Ulang</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="text" class="form-control" id="inputNamaTagihan" placeholder="Nama tagihan" hidden>
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" name="nominal" id="nominal"
                            placeholder="Nominal tagihan">
                    </div>
                    <div class="input-group mb-2">
                        <input type="date" class="form-control" name="waktu_dibuat" id="waktudibuat">
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" onclick="activate_cicilan()" id="act_checkbox" name="dicicil"
                            class="form-check-input">
                        <label class="form-check-label">Bisa di cicil</label>
                    </div>
                    <div class="form-group">
                        <select id="jumlahcicilan" name="jumlahCicilan" onclick="selectCil()"
                            class="custom-select form-control-sm" disabled>
                            <option selected>Choose...</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option disabled>Custom</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="custom-select" name="kelas" <?= isset($_GET['nis']) ? 'disabled' : 'required' ?>>
                            <option selected>Kelas</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="input-group mb-2 d-none" id="field">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" id="nom1" name="nom1" placeholder="Nominal tagihan">
                    </div>
                    <div class="input-group mb-2 d-none" id="field">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" id="nom2" name="nom2" placeholder="Nominal tagihan">
                    </div>
                    <div class="input-group mb-2 d-none" id="field">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" id="nom3" name="nom3" placeholder="Nominal tagihan">
                    </div>
                    <div class="input-group mb-2 d-none" id="field">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                        </div>
                        <input type="number" class="form-control" id="nom4" name="nom4" placeholder="Nominal tagihan">
                    </div>
                    <input type="submit" class="btn btn-info float-right btn-sm" name="submit" value="Buat">
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-primary">
            <div class="card-header bg-primary">
                <form action="" method="post">
                    <div class="d-flex flex-row">
                        <div class="col-auto">
                            <div class="btn-group">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Show
                                </button>
                                <div class="dropdown-menu">
                                    <form action="" method="post">
                                        <button class="dropdown-item" type="submit" name="limit" value="2">2</button>
                                        <button class="dropdown-item" type="submit" name="limit" value="5">5</button>
                                        <button class="dropdown-item" type="submit" name="limit" value="10">10</button>
                                        <button class="dropdown-item" type="submit" name="limit" value="15">15</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="text" class="form-control form-control-sm" name="keyword"
                                    placeholder="Search">
                                <div class="input-group-prepend">
                                    <button type="submit" name="btnsearch" class="input-group-text btn btn-light"><i
                                            class="fas fa-search "></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-sm">
                    <thead>
                        <tr>
                            <th>ID Tagihan</th>
                            <th>NIS</th>
                            <th>Nama Tagihan</th>
                            <th>Tagihan</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        (int) $offset = 0;
                        $limit = (isset($_POST['limit'])) ? intval($_POST['limit']) : 5;
                        $keyword = (isset($_POST['btnsearch'])) ? $_POST['keyword'] : '';

                        // var_dump($admController->tbtagihan(10, 0, ''));
                        $page = (isset($_GET['offset'])) ? intval($_GET['offset']) : 1;
                        $offset = ($page > 1) ? ($page * $limit) - $limit : 0;
                        $responOfTbTransaksi = $admController->tbtagihan($limit, $offset, $keyword);

                        foreach ($responOfTbTransaksi['data'] as $rows) : ?>
                        <tr>
                            <td><?= $rows['id_tagihan'] ?></td>
                            <td><?= $rows['nis'] ?></td>
                            <td><?= $rows['nm_tagihan'] ?></td>
                            <td><?= $rows['nominal'] ?></td>
                            <?php if ($rows['payment_type'] != null) : ?>
                            <td><?= $rows['payment_type'] ?></td>
                            <?php else : ?>
                            <td class="text-center">-</td>
                            <?php endif ?>
                            <?php if ($rows['status_code'] == "200") : ?>
                            <td><span class="badge bg-success text-white">Lunas</span></td>
                            <?php elseif ($rows['status_code'] == "201") : ?>
                            <td><span class="badge bg-warning text-white">Pending</span></td>
                            <?php elseif ($rows['status_code'] == "407") : ?>
                            <td><span class="badge bg-danger text-white">Kadaluarsa</span></td>
                            <?php elseif ($rows['status_code'] == null) : ?>
                            <td><span class="badge bg-primary text-white">onProses</span></td>
                            <?php endif ?>
                            <?php if ($rows['id_transaksi'] != null) : ?>
                            <?php $d = $admController->ambilDetail($rows['id_transaksi'])['data'] ?>
                            <td>
                                <a href="#" class="btn btn-sm btn-info" role="button" id="linkdetails"
                                    data-target="#modalDetailCash" data-toggle="modal" data-nis="<?= $d['nis'] ?>"
                                    data-nama="<?= $d['nama'] ?>" data-semester="<?= $d['semester'] ?>"
                                    data-kelas="<?= $d['kelas'] ?>" data-idtagihan="<?= $d['id_tagihan'] ?>"
                                    data-trtime="<?= $d['tr_time'] ?>" data-paymenttype="<?= $d['payment_type'] ?>"
                                    data-vanumber="<?= $d['va_number'] ?>" data-nmtagihan="<?= $d['nm_tagihan'] ?>"
                                    data-trnom="<?= $d['trnom'] ?>" data-statustr="<?= $d['status_tr'] ?>">Detail</a>
                            </td>
                            <?php else : ?>
                            <td><button type="submit" id="btnBayar" data-target="#modalBtnPembayaran"
                                    data-toggle="modal" data-idtransaksi="<?= $rows['id_tagihan'] ?>"
                                    data-nis="<?= $rows['nis'] ?>" data-nominal="<?= $rows['nominal'] ?>"
                                    class="btn btn-sm btn-success">Bayar</button></td>
                            <?php endif ?>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <nav aria-label="Page navigation example" class="mt-2">
            <ul class="pagination pagination-sm justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php for($i=1; $i <= ceil($responOfTbTransaksi['total_row'] / $limit); $i++) : ?>
                <li class="page-item <?= ($page == $i) ? 'active' : null ?>"><a class="page-link"
                        href="?page=invoice&offset=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
var act_checkbox = document.querySelector("#act_checkbox");
var field_cil = document.querySelectorAll("#field");
var jml_cil = document.getElementById("jumlahcicilan");
var btn_pot = document.querySelector("#btn-potongan");
var btn_edit = document.querySelectorAll("#btn-edit");

function selectCil() {
    var cil_index = jml_cil.options[jml_cil.selectedIndex].text;

    for (var i = 0; i < parseInt(cil_index); i++) {
        // console.log(i);
        // var current = field_cil[i].className.replace(" d-none");
        field_cil[i].setAttribute("class", "input-group mb-2");
    }
}

function activate_cicilan() {
    if (act_checkbox.checked) {
        document.querySelector("#nominal").disabled = true;
        document.querySelector("#jumlahcicilan").disabled = false;
    } else {
        document.querySelector("#nominal").disabled = false;
        document.querySelector("#jumlahcicilan").disabled = true;
    }
}

$("#selectNamaTagihan").change(function() {
    if ($(this).val() == "custom") {
        $("#inputNamaTagihan").removeAttr('hidden');
        $("#inputNamaTagihan").attr('name', 'nmtagihan');
        $("#selectNamaTagihan").remove();
    }
});

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

$(document).on('click', 'button#btnBayar', function() {
    $("button[name='btn-cash']").attr('value', $(this).data('idtransaksi'));
    $("input[name='nis']").attr('value', $(this).data('nis'));
    $("input[name='nominal']").attr('value', $(this).data('nominal'));
    console.log($(this).data('idtransaksi'));
});
</script>
<!-- Modal -->
<div class="modal fade" id="bukti-tagihan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pembayaran</h5>
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
                                            <img src="../../assets/images/logo.png" style="height: 35px; width: 35px;"
                                                alt="">
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
                    <div class="col">
                        <div class="row text-muted mr-4 ml-4 mb-2 justify-content-between" style="font-size: 12px;">
                            <div class="col-sm-5">
                                <div>
                                    <span>NIS : <span id="nis"></span>
                                </div>
                                <div>
                                    <span>Nama : <span id="nama"></span>
                                </div>
                                <div>
                                    <span>Kelas : <span id="kelas"></span>
                                </div>
                                <div>
                                    <span>Id Tagihan : <span id="id-order"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-5">
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
                    <div class="col-sm-10">
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
<div class="row mt-4 mb-5 justify-content-center">
    <div class="col-sm-auto mb-2">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table table-responsive" id="tb-tagihan">
                    <thead>
                        <tr>
                            <th colspan="6" class="text-center text-uppercase">Tagihan yang perlu dibayar</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Nama Tagihan</th>
                            <th>Nominal Tagihan</th>
                            <th>Tandai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query_select_t = $conn->query("select * from tagihan where id_transaksi is null && nis='$nis'");
                        if ($query_select_t->num_rows === 0) {
                            echo "<tr><td colspan='5' class='text-center'>Tidak adaTagihan</td></tr>";
                        } else {
                            while ($rows = $query_select_t->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $rows['nm_tagihan']; ?></td>
                            <td><?= $rows['nominal']; ?></td>
                            <td>
                                <form action="?page=proses" method="POST">
                                    <input type="checkbox" name="tandaiid[]" value="<?= $rows['id_tagihan']; ?>">
                            </td>
                        </tr>
                        <?php  }
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">
                                <input type="submit" class="btn btn-info float-right btn-sm" name="bayar"
                                    value="Checkout">
                                </form>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-auto ml-5">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table table-sm table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                            <th colspan="8" class="text-center text-uppercase">Status Transaksi</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Nama Tagihan</th>
                            <th>Nominal</th>
                            <th>Waktu</th>
                            <th>Bank</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $q_select_tr = $conn->query("select * from transaksi tr 
                    inner join tagihan t on tr.id_transaksi=t.id_transaksi where tr.nis='$nis'");

                        if ($q_select_tr) {
                            while ($rows = $q_select_tr->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $rows['nm_tagihan']; ?></td>
                            <td>Rp. <?= $rows['nominal']; ?></td>
                            <td><?= date_format(date_create($rows['waktu_dibuat']), "Y/m/d"); ?></td>
                            <td><?= $rows['bank']; ?></td>
                            <td>
                                <?php 
                                        $status = $rows['status_code'];
                                        $status_tr = $rows['status_tr'];
                                        if ($status == null) {
                                            echo "<span class='badge badge-info'>onProses</span>";
                                        } elseif ($status == "200") {
                                            echo "<span class='badge badge-success'>Succes</span>";
                                        } elseif ($status == "201") {
                                            echo "<span class='badge badge-warning'>Pending</span>";
                                        } elseif ($status == "407") {
                                            echo "<span class='badge badge-danger'>$status_tr</span>";
                                        }

                                        ?>
                            </td>
                            <td><button id="btn-detail" class="btn badge badge-info" data-toggle="modal"
                                    data-target="#bukti-tagihan" value="<?= $rows['id_transaksi']; ?>">Detail</button>
                            </td>
                        </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
var btn_detail = document.querySelectorAll("#btn-detail");

for (var i = 0; i < btn_detail.length; i++) {
    btn_detail[i].addEventListener('click', function() {
        const id_transaksi = this.value;
        $.ajax({
            url: 'get_transaksi.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id_transaksi: id_transaksi
            },
            success: function(data) {
                $("#nis").html(data.nis);
                $("#semester").html(data.semester);
                $("#nama").html(data.nama);
                $("#kelas").html(data.kelas);
                $("#nm-tagihan").html(data.nm_tagihan);
                $("#id-order").html(data.order_id);
                $("#code-va").html(data.va_number);
                $("#type-payment").html(data.payment_type);
                $("#tr-time").html(data.tr_time);
                $("#periode").html(data.periode);
                $("#status").html(data.status_tr);
                $("#nominal").html(data.trnom);

                if (data.status_code === "200") {
                    $("#cetak").show();
                    $("#cetak").attr("href", "cetak_bukti.php?id=" + data.id_transaksi);
                } else {
                    $("#cetak").hide();
                }
                console.log(data);
            }
        });
    });
}
</script>
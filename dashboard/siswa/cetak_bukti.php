<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Bukti Pembayaran</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-auto">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="text-center">
                                            <img src="../../assets/images/logo.png" style="height: 35px; width: 35px;" alt="">
                                        </div>
                                    </td>
                                    <td>
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
                    <div class="col-sm-10">
                        <div class="row text-muted mr-4 ml-4 mb-2 justify-content-around" style="font-size: 13px;">
                            <div class="col-sm-auto">
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
                                    <span>No Kuitansi : <span id="id-order"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <span>Semester : <span id="semester"></span>
                                </div>
                                <div>
                                    <span>Tanggal Pembayaran : <span id="tr-time"></span></span>
                                </div>
                                <div>
                                    <span>Payment : <span id="type-payment"></span></span>
                                </div>
                                <!-- <div>
                                    <span>VA Number : <span id="code-va"></span></span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-auto">
                        <table class="table table-sm table-bordered table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>Nama Tagihan</th>
                                    <th>Periode</th>
                                    <th>Potongan</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
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
    <script>
        var id_transaksi = '<?= $_GET['id']; ?>';

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
                // $("#code-va").html(data.va_number);
                $("#type-payment").html(data.payment_type);
                $("#tr-time").html(data.tr_time);
                $("#periode").html(data.periode);
                $("#status").html(data.status_tr);
                $("#nominal").html(data.trnom);
                console.log(data);
            }
        });

        $(document).ready(function(){
            window.print();
        });
    </script>
</body>

</html>
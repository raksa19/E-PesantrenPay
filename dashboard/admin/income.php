<div class="row mb-3 d-flex justify-content-center">
    <div class="col-md-3 col-6">
        <div class="card text-white bg-success mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('200') ?></h4>
                <i class="fas fa-check-circle" style="font-size: 20px;"></i>
            </div>
            <div class="card-footer btn-sm text-white text-center">Success</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-white bg-warning mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('201') ?></h4>
                <i class="fas fa-dna" style="font-size: 20px;"></i>
            </div>
            <div class="card-footer btn-sm text-white text-center">Pending</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-white bg-danger mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('407') ?></h4>
                <i class="fas fa-times-circle" style="font-size: 20px;"></i>
            </div>
            <div class="card-footer btn-sm text-white text-center">Expire</div>
        </div>
    </div>
    <!-- <div class="col-md-3 col-6">
        <div class="card text-white bg-primary mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4></h4>
                <i class="fas fa-male" style="font-size: 20px;"></i>
            </div>
            <a href="" class="card-footer btn-sm text-white text-center">Siswa Laki - laki</a>
        </div>
    </div> -->
</div>

<div class="row mt-3 mb-5 d-flex justify-content-center">
    <div class="col-md-5 mb-3">
        <div class="card">
            <div class="card-header">
                Bulanan
            </div>
            <div class="card-body">
                <canvas id="bulanan"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-3">
        <div class="card">
            <div class="card-header">
                Tahunan
            </div>
            <div class="card-body">
                <canvas id="tahunan"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header bg-primary">
                Data Pemasukkan
            </div>
            <div class="card-body">
                <table class="table table-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Periode</th>
                            <th>Nama Tagihan</th>
                            <th>Waktu Transaksi</th>
                            <th>Waktu Tagihan</th>
                            <th>Nominal</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th>Bank</th>
                        </tr>
                    </thead>
                    <tbody id="tb-income">
                        <?php
                        $limit = 5;
                        $page = empty($_GET['halaman']) ? 1 : intval($_GET['halaman']);
                        $mulai = $page > 1 ? ($page * $limit) - $limit : 0;
                        $no = $page > 1 ? $mulai : 1;
                        foreach ($admController->tbIncome(true, $limit, $mulai) as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nis'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['kelas'] ?></td>
                                <td><?= date_format(date_create($row['waktu_masuk']), "Y") . " " . $row['semester'] ?></td>
                                <td><?= $row['nm_tagihan'] ?></td>
                                <td><?= date_format(date_create($row['tr_time']), "Y/m/d") ?></td>
                                <td><?= date_format(date_create($row['waktu_dibuat']), "Y/m/d") ?></td>
                                <td><?= $row['trnom'] ?></td>
                                <td><?= $row['payment_type'] ?></td>
                                <?php if ($row['status_code'] === "200") : ?>
                                    <td><span class="badge badge-success"><?= $row['status_tr'] ?></span></td>
                                <?php elseif ($row['status_code'] === "201") : ?>
                                    <td><span class="badge badge-warning"><?= $row['status_tr'] ?></span></td>
                                <?php elseif ($row['status_code'] === "407") : ?>
                                    <td><span class="badge badge-danger"><?= $row['status_tr'] ?></span></td>
                                <?php endif ?>
                                <td><?= $row['bank'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<nav aria-label="Page navigation">
  <ul class="pagination float-right">
    <li class="page-item"><a class="page-link" href="?page=income&halaman=<?= $page - 1 ?>">Previous</a></li>
    <?php 
    $total_row = intval($admController->tbIncome()[0]['total']) / 5;
    for((int) $i=1; $i <= ceil($total_row)+1; $i++) : ?>
    <li class="page-item <?= ($page == $i) ? 'active' : null ?>"><a class="page-link" href="?page=income&halaman=<?= $i?>"><?= $i ?></a></li>
    <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li> -->
    <?php endfor ?>
    <li class="page-item"><a class="page-link" href="?page=income&halaman=<?= $page + 1 ?>">Next</a></li>
  </ul>
</nav>

<script>
    
    new Chart(document.getElementById('bulanan'), {
        type: 'bar',
        data: {
            labels: [<?php
                        foreach ($admController->dataIncome(true) as $data) {
                            echo "'".date_format(date_create($data['bulan']), "M") . "',";
                        }
                        ?>],
            datasets: [{
                label: 'Bulan',
                data: [<?php
                        foreach ($admController->dataIncome(true) as $data) {
                            echo $data['tbulan'] . ",";
                        }
                        ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            }]
        },
        options: {
            responsive: true
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Doughnut Chart'
            }
        }
    });

    new Chart(document.getElementById('tahunan'), {
        type: 'bar',
        data: {
            labels: [<?php
                        foreach ($admController->dataIncome() as $data) {
                            echo $data['tahun'] . ",";
                        }
                        ?>],
            datasets: [{
                label: 'Tahun',
                data: [<?php
                        foreach ($admController->dataIncome() as $data) {
                            echo $data['ttahun'] . ",";
                        }
                        ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            }]
        },
        options: {
            responsive: true
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Doughnut Chart'
            }
        }
    });
    
</script>
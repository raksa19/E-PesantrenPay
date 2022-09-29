<?php
$halaman = 10;
$page = isset($_GET['halaman']) ? intval($_GET['halaman']) : 1;
$mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;

$dataAngkatan = $admController->ambilDataAngkatan();

//filter by kelas untuk export data siswa
$exportBy = null;

//respon dari fungsi pencarian dan filter
$dataSiswa = null;

//total row tabel data siswa
$total_row = ceil($admController->tbDataSiswa()['total_row'] / $halaman);

if (isset($_POST['kelas'])) {
    $dataSiswa = $admController->tbDataSiswa(['kelas' => $_POST['kelas']], $halaman, $mulai)['data'];
    $exportBy = $_POST['kelas'];
} elseif (isset($_POST['semester'])) {
    $dataSiswa = $admController->tbDataSiswa(['semester' => $_POST['semester']], $halaman, $mulai)['data'];
} elseif (isset($_POST['cari'])) {
    $dataSiswa = $admController->tbDataSiswa(['keyword' => $_POST['pencarian']], $halaman, $mulai)['data'];
}
 else {
    $dataSiswa = $admController->tbDataSiswa(null, $halaman, $mulai)['data'];
}

//cek jika tombol kirim di klik

if (isset($_POST['kirim'])) {
    $data = [
        'from_user' => strtoupper($data['nama']),
        'to_user' => isset($_POST['to_user']) ? $_POST['to_user'] : strtolower("all"),
        'id_from' => intval($data['nis']),
        'id_to' => isset($_POST['id_to']) ? $_POST['id_to'] : 0,
        'pesan' => $_POST['pesan']
    ];

    $respon = $admController->kirimPesan($data);

    if ($respon['data']) {
        echo "<script>window.location.replace('index.php?page=datsiswa')</script>";
    }
}

//ubah kelas
$update_kelas = (isset($_POST['ubah_kelas'])) ?
    $admController->ubahKelas($_POST) : null;

if (isset($update_kelas['status'])) {
    echo "<script>window.location.href = index.php?page=datsiswa</script>";
}

//tambah data siswa

if (isset($_POST['tambahData'])){
    $respon = $admController->tambahDataSiswa([
        'nis' => $_POST['nis'],
        'id_kelas' => $_POST['id_kelas'],
        'nama' => strtoupper($_POST['nama']),
        'semester' => $_POST['semester'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'ttl' => $_POST['ttl'],
        'waktu_masuk' => $_POST['waktu_masuk'],
        'kota' => $_POST['kota'],
        'no_hp' => $_POST['no_hp'],
        'nm_no' => $_POST['nm_no'],
        'alamat' => $_POST['alamat']
    ]);
    
    if ($respon['status']){
        echo "<script>window.location.replace('index.php?page=datsiswa')</script>";
    }

}

?>
<form action="" method="post">
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header d-flex p-2" style="max-height: 35px;">
                    <div class="card-title">
                        <p>Update Kelas</p>
                    </div>
                    <div class="card-tools ml-auto">
                        <button data-target="#collapseUpdateKelas" class="badge badge-primary" type="button"
                            style="float:right; border:none; outline: none; cursor:pointer;" data-card-widget="collapse"
                            data-toggle="collapse" title="Collapse" aria-expanded="false"
                            aria-controls="collapseUpdateKelas">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse show" id="collapseUpdateKelas">
                    <div class="card-body">
                        <select class="custom-select mb-2" name="angkatan">
                            <option selected disabled>Angkatan</option>
                            <?php foreach ($dataAngkatan as $data) : ?>
                            <option value="<?= date_format(date_create($data['waktu_masuk']), "Y") ?>">
                                <?= date_format(date_create($data['waktu_masuk']), "Y") ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="input-group">
                            <select class="custom-select" name="updatekelas"
                                aria-label="Example select with button addon">
                                <option selected disabled>Kelas</option>
                                <option value="0">Alumni</option>
                                <option value="313007">7</option>
                                <option value="313008">8</option>
                                <option value="313009">9</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" name="ubah_kelas">Ubah
                                    Kelas</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control mt-5" name="nis" placeholder="NIS">
                            <span><small class="text-muted">Optional.</small></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="card">
                <div class="card-header d-flex p-2" style="max-height: 35px;">
                    <div class="card-title">
                        <p>Data Santri Pertahun</p>
                    </div>
                    <div class="card-tools ml-auto">
                        <button data-target="#grafikDataSiswa" class="badge badge-primary" type="button"
                            style="float:right; border:none; outline: none; cursor:pointer;" data-card-widget="collapse"
                            data-toggle="collapse" title="Collapse" aria-expanded="false"
                            aria-controls="collapseUpdateKelas">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse show" id="grafikDataSiswa">
                    <div class="card-body">
                        <canvas id="myChart" height="160"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md col mb-3">
            <div class="card">
                <div class="card-header d-flex p-2" style="max-height: 35px;">
                    <div class="card-title">
                        <p>Message</p>
                    </div>
                    <div class="card-tools ml-auto">
                        <button data-target="#exportData" class="badge badge-primary" type="button"
                            style="float:right; border:none; outline: none; cursor:pointer;" data-card-widget="collapse"
                            data-toggle="collapse" title="Collapse" aria-expanded="false"
                            aria-controls="collapseUpdateKelas">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse show" id="exportData">
                    <div class="card-body">
                        <div class="form-group">
                            <textarea class="form-control" rows="3" name="pesan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary" name="kirim">Kirim</button>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</form>
<form action="" method="post" enctype="multipart/form-data">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="pencarian" id="pencarian" placeholder="Pencarian">
                <div class="input-group-prepend">
                    <button type="submit" name="cari" class="btn btn-outline-secondary"><i class="fa fa-search"
                            aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row mt-3 justify-content-center">
    <div class="col-sm-auto col-6 mb-3">
        <button data-target="#modaltambahSiswa" data-toggle="modal" class="btn btn-outline-warning mt-auto">Tambah Akun
            <i class="fas fa-plus"></i></button>
    </div>
    <div class="col-sm-auto col-6 mb-3">
        <form action="" method="POST">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Filter By Kelas</button>
            <div class="dropdown-menu">
                <button type="submit" class="dropdown-item" name="kelas" value="7">7</button>
                <button type="submit" class="dropdown-item" name="kelas" value="8">8</button>
                <button type="submit" class="dropdown-item" name="kelas" value="9">9</button>
            </div>
        </form>
    </div>
    <div class="col-sm-auto col-6 mb-3">
        <form action="" method="POST">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Filter By Semester</button>
            <div class="dropdown-menu">
                <button type="submit" class="dropdown-item" name="semester" value="gasal">Gasal</button>
                <button type="submit" class="dropdown-item" name="semester" value="genap">Genap</button>
            </div>
        </form>
    </div>
</div>
<div class="row mb-3 d-flex justify-content-center">
    <div class="col-lg col-sm-auto">
        <div class="card shadow">
            <div class="card-header bg-primary" style="max-height: 50px;">
                Data Santri
                <a href="?page=datsiswa&sub=report" class="btn btn-light btn-sm float-right"><i
                        class="fas fa-file-export"></i></a>
            </div>
            <div class="card-body table-responsive-sm">
                <table class="table table-striped table-hover table-wrapper" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama <i class="fas fa-sort float-right p-1" onclick="shortTable()"
                                    style="cursor: pointer;"></i></th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</i></th>
                            <th>Semester</th>
                            <th>Tahun Masuk</th>
                            <th>No HP</th>
                            <th>NIS</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tb-tbody">
                        <?php
                        $no = $page > 1 ? $mulai : 1;
                        $no_index = 0;
                        foreach ($dataSiswa as $rows) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $rows['nama']; ?></td>
                            <td><?= $rows['kelas']; ?></td>
                            <td><?= ($rows['jenis_kelamin'] == 'laki') ? 'Laki - Laki' : $rows['jenis_kelamin'] ?></td>
                            <td><?= $rows['semester']; ?></td>
                            <td><?= date_format(date_create($rows['waktu_masuk']), "Y"); ?></td>
                            <td><?= "0" . $rows['no_hp']; ?></td>
                            <td><?= $rows['nis']; ?></td>
                            <td>
                                <?php
                                    if ($rows['stakun'] == "online") {
                                        echo "<span class='badge badge-success'>Online</span>";
                                    } else {
                                        echo "<span class='badge badge-secondary'>Offline</span>";
                                    }
                                    ?>
                            </td>
                            <td>
                                <a href="./index.php?page=edit&id=<?= $rows['nis']; ?>" class="p-1" id="btn-action"><i
                                        class="fas fa-cog" aria-hidden="true"></i></a>
                                <a href="buat_tag.php?id=<?= $rows['nis']; ?>" class="p-1"><i
                                        class="fas fa-receipt"></i></a>
                                <a href="#" id="btnTambahakun" data-nis="<?= $rows['nis'] ?>"
                                    data-ttl="<?= $rows['ttl'] ?>" data-nama="<?= $rows['nama'] ?>"><i
                                        class="fas fa-plus-circle"></i></a>
                                <!-- <a href="#" data-target="#modal-pesan" data-toggle="modal"
                                    data-nis="<?= $rows['nis'] ?>" data-nama="<?= $rows['nama'] ?>" id="btn-message"
                                    class="p-1"><i class="far fa-paper-plane"></i></a> -->
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php if ($dataSiswa == null) : ?>
                        <tr class="text-center">
                            <td colspan="10">Data Tidak Ada</td>
                        </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end mb-5">
                <li class="page-item"><a class="page-link" href="?page=datsiswa&halaman=<?= $page - 1 ?>">Previous</a>
                </li>
                <?php for ((int) $i = 1; $i <= $total_row; $i++) : ?>
                <li class="page-item <?= ($page == $i) ? 'active' : null ?>"><a class="page-link"
                        href="?page=datsiswa&halaman=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor ?>
                <li class="page-item"><a class="page-link" href="?page=datsiswa&halaman=<?= $page + 1 ?>">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php
                        foreach ($admController->dataSiswaPerTahun() as $data) {
                            echo date_format(date_create($data['tmasuk']), "Y") . ",";
                        }
                        ?>],
        datasets: [{
            label: '# Data Per Tahun',
            data: [<?php
                        foreach ($admController->dataSiswaPerTahun() as $data) {
                            echo $data['jsiswa'] . ",";
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
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            // x: {
            //     type: 'time',
            //     min: new Date('2016-01-01').valueOf(),
            //     max: new Date('2021-12-31').valueOf()
            // },
            y: {
                // type: 'linear',
                // min: 0,
                // max: 100
                beginAtZero: true
            }
        },
        layout: {
            padding: 0
        },
        // spanGaps: true
    }
});

$(document).on('click', 'a#btn-message', function() {
    $("#inputnis").val($(this).data('nis'));
    $("#inputnama").val($(this).data('nama'));
});
$(document).ready(function() {
    $('a#btnTambahakun').on('click', function() {

        $.ajax({
            url: 'buat_akun.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                nis: $(this).data('nis'),
                nama: $(this).data('nama'),
                ttl: $(this).data('ttl')
            },
            success: function(data) {
                if (data.status) {
                    $("#alert").addClass('show');
                    $("#alert").html(data.pesan + " " + data.data);
                }
            }
        });
    });
});
</script>
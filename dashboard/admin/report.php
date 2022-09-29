<?php

require_once "Admin_Controller.php";

$admController = new Admin_Controller();

$limit = 5;
$page = (isset($_GET['offset'])) ? intval($_GET['offset']) : 1;
$offset = ($page > 1) ? ($page * $limit) - $limit : 0;

$respon = $admController->dataReport(['filterbykelas' => null, 'status' => ['201', '200']], $limit, $offset);

if (isset($_POST['btnfilter'])){
  $respon = $admController->dataReport($_POST, $limit, $offset);

}


?>
<form action="" method="post">
    <div class="row mb-3">
        <div class="col-lg-3">
            <div class="mb-2">
                <select class="custom-select mr-sm-2" name="filterbykelas">
                    <option selected value="">Choose...</option>
                    <option value="313007">7</option>
                    <option value="313008">8</option>
                    <option value="313009">9</option>
                </select>
                <small class="text-muted">Filter by Kelas</small>
            </div>
            <div class="mb-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="status[]" id="inlineCheckbox1" value="200"
                        <?= (in_array("200", $respon['filter'], true)) ? 'checked' : null ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Lunas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="status[]" id="inlineCheckbox2" value="201"
                        <?= (in_array("201", $respon['filter'], true)) ? 'checked' : null ?>>
                    <label class="form-check-label" for="inlineCheckbox2">Belum Lunas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="status[]" id="inlineCheckbox3" value="407"
                        <?= (in_array("407", $respon['filter'], true)) ? 'checked' : null ?>>
                    <label class="form-check-label" for="inlineCheckbox3">Kadaluarsa</label>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-end">
            <input type="submit" name="btnfilter" value="Filter" class="btn btn-sm btn-primary align-self-start">
            <a href="export_data_report.php?q=<?= $respon['q'] ?>"
                class="btn btn-sm btn-primary align-self-end ml-auto">Export</a>
        </div>
    </div>
</form>

<div class="row mb-3">
    <div class="col bg-light shadow">
        <div class="d-flex flex-row">
            <div class="col">
                <h5 class="p-2 text-center text-muted">Repot Data Tagihan Santri</h5>
            </div>
            <div class="col-md-auto">
                <nav aria-label="Page navigation example" class="mt-2">
                    <ul class="pagination pagination-sm justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for ($i=1; $i <= ceil($respon['total_row'] / $limit); $i++) : ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : null ?>"><a class="page-link"
                                href="?page=datsiswa&sub=report&offset=<?= $i ?>"><?= $i ?></a></li>
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
        <table class="table table-sm">
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
      $no = ($page > 1) ? $offset : 1;
      foreach ($respon['data'] as $row) : ?>
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
    </div>
</div>
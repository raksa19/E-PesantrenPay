<?php

if (isset($_POST['btnImportDatabase'])){
    $responData = $admController->importDataDatabase($_POST);
    
    if ($responData['status']){
        $_SESSION['alert'] = $responData['pesan'];
        echo ("<script>window.location.replace('index.php?page=datsiswa&sub=import')</script>");
    }
}

?>
<!-- Modal Contoh Format Excel -->
<div class="modal fade" id="modalContohFormat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe
                    src="https://docs.google.com/spreadsheets/d/e/2PACX-1vS3FG9Hq4W_S9RHWSkhwjYnVG9JeYriZiGOvMJ74dTTOipKE2sCf7q2wdIgtRu0VQ/pubhtml?gid=906188818&single=true"
                    frameborder="0" style="width: 100%; height: 200px;"></iframe>
                <a href="https://drive.google.com/file/d/1CKRM5qLBGY1tJI-Iw4LDfERA5277Jb_x/view?usp=sharing"
                    target="_blank">Download
                    Contoh</a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-3 mb-2">
        <form action="uploaded.php" method="POST" enctype="multipart/form-data">
            <div class="input-group border" style="width: 100%;">
                <label for="inputfile" class="pt-1 pl-2">
                    <i class="fas fa-file-import"></i>
                    <input type="file" name="file-import" id="inputfile" style="display: none; visibility: none;"
                        accept="xls, xlsx">
                </label>
                <div class="input-group-prepend ml-auto">
                    <button type="submit" name="btnimport" class="btn btn-info btn-sm">Import</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col mb-2">
        <button class="btn btn-info float-right" data-toggle="modal" data-target="#modalContohFormat">Contoh
            Format</button>
    </div>
</div>


<form action="" method="POST">
    <div class="row mb-2">
        <div class="col-lg-3">
            <select class="custom-select mr-sm-2" name="namafile">
                <option selected value="">Pilih File</option>
                <?php 
            $scandir = scandir('./uploads', 1);
            foreach ($scandir as $namaFile) :
                if (strpos($namaFile, 'xls')) :
                    ?>
                <option value="<?= $namaFile ?>"><?= explode('.', $namaFile)[0] ?></option>
                <?php endif ?>
                <?php endforeach ?>
            </select>
            <small class="text-muted">Pilih file yang akan di masukkan ke database.</small>
        </div>
        <div class="col-lg-4">
            <select class="custom-select mr-sm-2" name="namatabel" required>
                <option selected value="">Pilih Tabel</option>
                <option value="data_admin">Data Admin</option>
                <option value="data_siswa">Data Santri</option>
            </select>
            <small class="text-muted">Pilih tabel sesuai data yang ingin dimasukkan.</small>
        </div>
        <div class="col">
            <button type="submit" name="btnImportDatabase" class="btn btn-success">Import ke Database</button>
        </div>
    </div>
</form>


<div class="row">
    <div class="col bg-light">
        <h5 class="text-center text-muted p-2">History Import Data ke Database</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Waktu Upload</th>
                    <th>Waktu Import</th>
                    <th>Ukuran File</th>
                    <th>Extensi File</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $ambil_data_ht = $admController->db->query("select * from ht_tambah_data");
                $no = 1;
                ?>
                <?php while($data = $ambil_data_ht->fetch_assoc()) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data['nama_file'] ?></td>
                    <td><?= $data['waktu_upload'] ?></td>
                    <td><?= !empty($data['waktu_import']) ? $data['waktu_import'] : '-' ?></td>
                    <td><?= $data['ukuran_file'] ?></td>
                    <td><?= $data['extention_file'] ?></td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>
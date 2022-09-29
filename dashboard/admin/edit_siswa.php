<?php
$nis = $_GET['id'];

$data = $admController->ambilDataSiswa(intval($nis));

if (isset($_POST['simpan'])) {

    (array) $dataUser = [
        'nama' => $_POST['nama'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'kota' => $_POST['kota'],
        'id_kelas' => $_POST['id_kelas'],
        'semester' => $_POST['semester'],
        'nis' => $_POST['nis'],
        'alamat' => $_POST['alamat'],
        'no_hp' => $_POST['no_hp'],
        'nm_no' => $_POST['nm_no'],
        'email' => $_POST['email'],
    ];

    $respon = $admController->editDataSiswa($dataUser, intval($nis));
    
    if ($respon['status']){
        echo "<script>window.location.replace(?page=edit&nis=$nis)</script>";
    }
}

?>

<form action="" method="post">
    <div class="row justify-content-center mt-3">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col-sm-3 text-center">
                            
                        </div>
                        <div class="col-sm">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                        </div>
                                        <input type="text" class="form-control" name="nama" placeholder="<?= $data['nama']; ?>">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-mars"></i></div>
                                        </div>
                                        <select class="custom-select" name="jenis_kelamin">
                                            <option value='perempuan' <?= ($data['jenis_kelamin'] == "perempuan") ? 'selected' : null ?>>Perempuan</option>
                                            <option value='laki' <?= ($data['jenis_kelamin'] == "laki") ? 'selected' : null ?>>Laki - laki</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-home"></i></div>
                                        </div>
                                        <input type="text" class="form-control" name="kota" placeholder="<?= $data['kota']; ?>">
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-graduation-cap"></i></div>
                                        </div>
                                        <select class="custom-select" name="id_kelas">
                                            <option value='0' <?= ($data['kelas'] == "0") ? 'selected' : null ?>>Alumni</option>
                                            <option value='313007' <?= ($data['kelas'] == "7") ? 'selected' : null ?>>Kelas 7</option>
                                            <option value='313008' <?= ($data['kelas'] == "8") ? 'selected' : null ?>>Kelas 8</option>
                                            <option value='313009' <?= ($data['kelas'] == "9") ? 'selected' : null ?>>Kelas 9</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-book-reader"></i></div>
                                        </div>
                                        <select class="custom-select" name="semester">
                                            <option value='genap' <?= ($data['semester'] == "genap") ? 'selected' : null ?>>Genap</option>
                                            <option value='gasal' <?= ($data['semester'] == "gasal") ? 'selected' : null ?>>Gasal</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="far fa-id-badge"></i></div>
                                        </div>
                                        <input type="text" class="form-control" name="nis" placeholder="<?= $data['nis']; ?>">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-map-marked"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="alamat" placeholder="<?= $data['alamat']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nomer HP</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="no_hp" placeholder="0<?= $data['no_hp']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pemilik Nomer HP</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-address-book"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="nm_no" placeholder="<?= $data['nm_no']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Email</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-at"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="email" placeholder="<?= ($data['email'] == null) ? "belum create akun" : $data['email']; ?>">
                                </div>
                            </div>
                            <fieldset disabled>
                                <div class="form-group" disabled>
                                    <label for="">Nomer HP</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="far fa-id-badge"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="" placeholder="No induk" value="06775">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Pemilik Nomer HP</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="far fa-id-badge"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="" placeholder="No induk" value="06775">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col d-flex justify-content-end">
            <a href="./index.php?page=datsiswa" class="btn btn-outline-warning btn-sm m-2">Kembali</a>
            <button type="submit" name="simpan" class="btn btn-primary btn-sm m-2">Simpan</button>
            <a href="#" class="btn btn-success btn-sm m-2">Simpan & Terapkan</a>
        </div>
    </div>
</form>
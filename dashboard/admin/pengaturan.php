<?php

if (isset($_POST['simpan'])){
    
    $fname = !empty($_POST['fname']) ? strtoupper($_POST['fname']) : null;
    $lname = !empty($_POST['lname']) ? strtoupper($_POST['lname']) : null;
    $passwd = null;
    
    if (isset($_POST['newpassword'])){
        if ($_POST['newpassword'] != $_POST['confirmpassword']){
            $_SESSION['alert'] = "Passowrd Tidak Sama!";
        }else{
            $passwd = $_POST['newpassword'];
        }
    }

    $dataForm = [
        'nama' => (empty($fname) && empty($lname)) ? null : $fname." ".$lname,
        'email' => (!empty($_POST['email'])) ? $_POST['email'] : null,
        'alamat' => !empty($_POST['address']) ? $_POST['address'] : null,
        'kota' => !empty($_POST['kota']) ? $_POST['kota'] : null,
        'no_hp' => !empty($_POST['no_hp']) ? $_POST['no_hp'] : null,
        'nm_no' => !empty($_POST['nm_no']) ? $_POST['nm_no'] : null,
        'passwd' => $passwd
    ];

    $respon = $admController->updateDataAdmin($dataForm, intval($data['nis']));

    if ($respon['status']){
        $_SESSION['alert'] = $respon['pesan']." ".$respon['data'];
        echo "<script>window.location.replace('?page=setting')</script>";
    }

}

?>

<div class="row justify-content-center mb-5 mt-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Ubah Profil</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-auto">
                        <div class="col-sm-3 p-5">
                            <i class="fa fa-plus-circle change-pic" style="font-size:24px; color:black;"></i>
                            <img src="../../assets/icons/admin.png" class="rounded-circle"
                                style="width: 100px; height: 100px;" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form action="" method="POST">
                    <div class="row justify-content-center">
                        <div class="col-md-5 col-sm-auto">
                            <div class="form-group">
                                <label for="">Firstname</label>
                                <input type="text" class="form-control" name="fname"
                                    placeholder="<?= explode(" ", $data['nama'], 2)[0]; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Lastname</label>
                                <input type="text" class="form-control" name="lname"
                                    placeholder="<?= explode(" ", $data['nama'], 2)[1]; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Email</label>
                                <input type="text" class="form-control" name="email" id=""
                                    placeholder="<?= $data['email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Alamat</label>
                                <input type="text" class="form-control" name="address" id=""
                                    placeholder="<?= $data['alamat']; ?>">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-auto">
                            <div class="form-group">
                                <label for="inputAddress">Kota</label>
                                <input type="text" class="form-control" name="city" id=""
                                    placeholder="<?= $data['kota']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">No HP / Telpn</label>
                                <input type="text" class="form-control" name="no_hp" id=""
                                    placeholder="0<?= $data['no_hp']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Password Baru</label>
                                <input type="password" class="form-control" name="newpassword" id="new-passwd">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmpassword" id="confirm-passwd">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-sm-auto">
                            <button type="submit" name="simpan"
                                class="btn btn-sm btn-primary float-right ml-2">Simpan</button>
                            <a href="?page=tagihan" class="btn btn-sm btn-outline-warning float-right">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

$fname = !empty($_POST['fname']) ? strtoupper($_POST['fname']) : explode(" ", $data['nama'], 2)[0];
$lname = !empty($_POST['lname']) ? strtoupper($_POST['lname']) : explode(" ", $data['nama'], 2)[1];

$passwd = null;
if (isset($_POST['newpassword'])){
    if ($_POST['newpassword'] === $_POST['confirmpassword']){
        $passwd = $_POST['newpassword'];
    }
}

if (isset($_POST['simpan'])){
    $dataForm = [
        'nama' => (empty($fname) && empty($lname)) ? null : $fname." ".$lname,
        'email' => !empty($_POST['email']) ? $_POST['email'] : null,
        'alamat' => !empty($_POST['address']) ? $_POST['address'] : null,
        'kota' => !empty($_POST['kota']) ? $_POST['kota'] : null,
        'no_hp' => !empty($_POST['no_hp']) ? $_POST['no_hp'] : null,
        'nm_no' => !empty($_POST['nm_no']) ? $_POST['nm_no'] : null,
        'passwd' => $passwd
    ];

    $respon = $siswaController->updateDataSiswa($dataForm, intval($data['nis']));

    if ($respon['status']){
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
                            <img src="https://sim.unusa.ac.id/siakad/siakad/uploads/fotomhs/<?= $tahun_masuk; ?>/<?php echo $nis; ?>.jpg?r=94804" class="rounded-circle" style="width: 100px; height: 100px;" alt="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form action="" method="POST">
                    <div class="row justify-content-center">
                        <div class="col-md-5 col-sm-auto">
                            <!-- <div class="form-row">
                                </div> -->
                            <div class="form-group">
                                <label for="">Firstname</label>
                                <input type="text" class="form-control" name="fname" placeholder="<?= explode(" ", $data['nama'], 2)[0]; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Lastname</label>
                                <input type="text" class="form-control" name="lname" placeholder="<?= explode(" ", $data['nama'], 2)[1]; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Email</label>
                                <input type="text" class="form-control" name="email" id="" placeholder="<?= $data['email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Alamat</label>
                                <input type="text" class="form-control" name="address" id="" placeholder="<?= $data['alamat']; ?>">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-auto">
                            <div class="form-group">
                                <label for="inputAddress">Kota</label>
                                <input type="text" class="form-control" name="city" id="" placeholder="<?= $data['kota']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">No HP / Telpn</label>
                                <input type="text" class="form-control" name="no_hp" id="" placeholder="0<?= $data['no_hp']; ?>">
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
                            <button type="submit" name="simpan" class="btn btn-sm btn-primary float-right ml-2">Simpan</button>
                            <a href="?page=tagihan" class="btn btn-sm btn-outline-warning float-right">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // $('form').submit(function(e) {
        //     var that = $(this),
        //         url = that.attr("action"),
        //         method = that.attr("method");

        //     // var fname = $([name="fname"]).val();
        //     // console.log(fname);
        //     // console.log($(this).serialize())
        //     var data = {
        //         nis: '<?= $data['nis']; ?>'
        //     };
        //     $('input[type="text"]').each(function(i, v) {
        //         var plach = $(this).attr('placeholder');
        //         var name = $(this).attr('name');

        //         if (v.value === "") {
        //             data[name] = plach;
        //         } else {
        //             data[name] = v.value;
        //         }
        //     });
        //     console.log(JSON.stringify(data));
        //     xhrrequest(method, url, JSON.stringify(data), function(e) {
        //         var alert = document.getElementById('div-alert');
        //         alert.setAttribute("class", "alert alert-success alert-dismissible fade show");
        //         document.getElementById('pesan').innerHTML = "Berhasil di update!";
        //     });
        // });

        // document.getElementById('ubah').addEventListener('click', function() {
        //     var id_user = document.getElementById('id-user').value;
        //     var new_pass = document.getElementById('new-passwd').value;
        //     var confirm_pass = document.getElementById('confirm-passwd').value;

        //     if (new_pass != confirm_pass) {
        //         $("#div-alert").fadeIn();
        //         $("#div-alert").addClass("alert-warning show");
        //         $("#pesan").html("Password tidak sama!");
        //         setTimeout(function() {
        //             $("#div-alert").fadeOut();
        //         }, 2000);
        //     } else {

        //         const data = {
        //             id_user: id_user,
        //             new_pass: new_pass,
        //         };
        //         $.ajax({
        //             url: 'update_password.php',
        //             type: 'POST',
        //             data: data,
        //             success: function(data) {
        //                 $("#div-alert").fadeIn();
        //                 $("#div-alert").addClass("alert-success show");
        //                 $("#pesan").html(data);
        //                 setTimeout(function() {
        //                     $("#div-alert").fadeOut();
        //                 }, 2000);
        //             }
        //         });

        //         $('form')[0].reset();
        //     }

        // });
    });
</script>
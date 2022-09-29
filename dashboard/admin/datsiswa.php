<div class="modal fade" id="action" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="">Hapus atau Ubah</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="dprofile"></div>
                <a href="#" class="btn btn-outline-warning p-3 mr-4" id="btn-ubah"><i class="fas fa-user-edit"
                        style="font-size: 25px;"></i></a>
                <button class="btn btn-outline-danger p-3 ml-4" id="btn-hps"><i class="fas fa-trash-alt"
                        style="font-size: 25px;"></i></button>
            </div>
            <div class="modal-footer" id="fmodal">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak jadi</button>
                <button type="button" id="hapus" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modaltambahSiswa">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="tambah" method="POST">
                <div class="modal-body">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-user-alt" style="font-size: 20px;"></i></div>
                        </div>
                        <input type="text" class="form-control" name="nama" id="" placeholder="nama">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-mars" style="font-size: 24px;"></i></div>
                        </div>
                        <select class="custom-select" name="jenis_kelamin">
                            <option value="laki" selected>Laki - laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-home" style="font-size: 18px;"></i></div>
                        </div>
                        <input type="text" class="form-control" name="kota" id="" placeholder="Kota">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-calendar" style="font-size: 22px;"></i></div>
                        </div>
                        <input type="date" class="form-control" name="waktu_masuk" id="">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-graduation-cap" style="font-size: 16px;"></i>
                            </div>
                        </div>
                        <select class="custom-select" name="id_kelas">
                            <option value="" selected>Kelas ...</option>
                            <option value="313007">Kelas 7</option>
                            <option value="313008">Kelas 8</option>
                            <option value="313009">Kelas 9</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-book-reader" style="font-size: 20px;"></i>
                            </div>
                        </div>
                        <select class="custom-select" name="semester">
                            <option value="" selected>Semester</option>
                            <option value="gasal">Gasal</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-id-badge" style="font-size: 26px;"></i></div>
                        </div>
                        <input type="text" class="form-control" name="nis" id="" placeholder="NIS">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-map-marked" style="font-size: 18px;"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="alamat" id="" placeholder="Alamat Rumah">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-birthday-cake"
                                    style="font-size: 23px;"></i></i></div>
                        </div>
                        <input type="date" class="form-control" name="ttl" id="" placeholder="Tahun Tanggal Lahir">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-mobile" style="font-size: 22px;"></i></div>
                        </div>
                        <input type="text" class="form-control" name="no_hp" id="" placeholder="No HP">
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-address-book" style="font-size: 22px;"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="nm_no" id="" placeholder="Noama pemilik nomer HP">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="tambahData" value="Tambahkan">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pesan -->
<div class="modal fade" id="modal-pesan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Kirim Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body text-center">
                    <textarea rows="5" cols="60" style="padding: 5px;" name="pesan"></textarea>
                    <input type="hidden" id="inputnis" name="id_to">
                    <input type="hidden" id="inputnama" name="to_user">
                    <button type="submit" name="kirim" class="btn btn-sm btn-primary float-right m-2">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mb-4 d-flex justify-content-center">
    <div class="col-md-3 col-6">
        <div class="card text-white bg-info mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('SISWA') ?></h4>
                <i class="fas fa-user-graduate" style="font-size: 20px;"></i>
                <!-- <p class="card-text"></p> -->
            </div>
            <a href="" class="card-footer btn-sm text-white text-center">Santri</a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-white bg-warning mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('USER_SISWA') ?></h4>
                <i class="fas fa-user" style="font-size: 20px;"></i>
                <!-- <p class="card-text">User Siswa</p> -->
            </div>
            <a href="" class="card-footer btn-sm text-white text-center">User Santri</a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-dark bg-light mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('SISWA_PEREMPUAN') ?></h4>
                <i class="fas fa-female" style="font-size: 20px;"></i>
                <!-- <p class="card-text">User Siswa</p> -->
            </div>
            <a href="" class="card-footer btn-sm text-dark text-center">Santri Perempuan</a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-white bg-dark mb-3 shadow" style="max-width: 13rem;">
            <div class="card-body text-center">
                <h4><?= $admController->ambilJumlahData('SISWA_LAKI') ?></h4>
                <i class="fas fa-male" style="font-size: 20px;"></i>
                <!-- <p class="card-text">User Siswa</p> -->
            </div>
            <a href="" class="card-footer btn-sm text-white text-center">Santri Laki - laki</a>
        </div>
    </div>
</div>

<?php
if (isset($_GET['sub'])){
    if ($_GET['sub'] == "import"){
        include "import.php";
    }else if ($_GET['sub'] == "pesan"){
        include "pesan.php";
    }else if ($_GET['sub'] == "report") {
        include "report.php";
    }
}else{
    include "tb_siswa.php";
}
?>


<script type="text/javascript">
$("button[data-dismiss='modal']").on("click", function() {
    $("#dprofile").empty();
    $("#btn-ubah").show();
    $("#btn-hps").show();
});
</script>
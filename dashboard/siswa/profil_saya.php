<div class="row mt-3 mb-5 justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header text-center d-flex">
                <i class="fa fa-id-card mr-2" style="font-size: 24px;"></i>
                <?= $data['nama']; ?>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col text-center">
                        <img src="https://sim.unusa.ac.id/siakad/siakad/uploads/fotomhs/<?= $tahun_masuk; ?>/<?php echo $nis; ?>.jpg?r=94804" class="card-img rounded" style="width: auto; height: 200px;" alt="...">
                    </div>
                    <div class="col-lg-5 col-sm-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-user-alt p-2"></i>
                                <span><?= $data['nama']; ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-mars p-2"></i>
                                <span><?= $data['jenis_kelamin']; ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-home p-2"></i>
                                <span><?= $data['kota']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-5 col-sm-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa fa-graduation-cap p-2"></i>
                                <span>Kelas <?= $data['kelas']; ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-book-reader p-2"></i>
                                <span><?= $data['semester']; ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="far fa-id-badge p-2"></i>
                                <span><?= $data['nis']; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-sm-auto">
                        <fieldset disabled>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-map-marked"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="" placeholder="Alamat Rumah" value="<?= $data['alamat'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nomer HP</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-mobile"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="" placeholder="No HP" value="<?= "0" . $data['no_hp']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pemilik Nomer HP</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-address-book"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="" placeholder="Noama pemilik nomer HP" value="<?= $data['nm_no']; ?>">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-5 col-sm-auto">
                        <fieldset disabled>
                            <div class="form-group">
                                <label for="">Email</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-at"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="" placeholder="email" value="<?= $data['email']; ?>">
                                </div>
                            </div>
                            <div class="form-group" disabled>
                                <label for="">Nomer HP</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-id-badge"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="" placeholder="No induk" value="-">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pemilik Nomer HP</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-id-badge"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="" placeholder="No induk" value="-">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
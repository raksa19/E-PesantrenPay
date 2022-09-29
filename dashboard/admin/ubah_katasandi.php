<div class="row mt-5 mb-5 justify-content-center">
    <div class="col-sm-5">
        <div class="card">
            <div class="card-header text-center d-flex">
                <i class="fa fa-id-card p-2" style="font-size: 24px;"></i>
                <h2 class="card-title">Lupa Kata Sandi mu yaa.. :)</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-center">
                        <img src="../../assets/images/pass_foto.jpg" class="card-img-top rounded" style="width: auto; height: 200px;" alt="...">
                        <div class="mt-2">
                            <h5><?= $data['nama']; ?></h5>
                        </div>
                    </div>
                    <div class="col">
                        <form action="">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                        </div>
                                          <input type="text" class="form-control" placeholder="Email atau NIS">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                        </div>
                                          <input type="text" class="form-control" placeholder="New Password">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                        </div>
                                          <input type="text" class="form-control" placeholder="Confirm Password">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <button type="submit" class="btn btn-outline-success">Ubah</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
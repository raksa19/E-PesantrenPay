<div class="row justify-content-center">
    <div class="col-sm-auto">
        <div class="card m-sm-5">
            <div class="card-header text-center d-flex">
                <i class="fa fa-id-card p-2" style="font-size: 24px;"></i>
                <h2 class="card-title">Ubah Passowrd</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-center">
                        <img src="https://sim.unusa.ac.id/siakad/siakad/uploads/fotomhs/<?= $tahun_masuk; ?>/<?php echo $nis; ?>.jpg?r=94804" class="card-img rounded" style="width: auto; height: 200px;" alt="...">
                        <div class="mt-2">
                            <h5><?= $data['nama']; ?></h5>
                        </div>
                    </div>
                    <div class="col">
                        <form>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Email atau NIS" id="id-user">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                        </div>
                                        <input type="password" class="form-control" placeholder="New Password" id="new-passwd">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Confirm Password" id="confirm-passwd">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-outline-success" id="ubah">Ubah</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('ubah').addEventListener('click', function() {
        var id_user = document.getElementById('id-user').value;
        var new_pass = document.getElementById('new-passwd').value;
        var confirm_pass = document.getElementById('confirm-passwd').value;

        if (new_pass != confirm_pass) {
            $("#div-alert").fadeIn();
            $("#div-alert").addClass("alert-warning show");
            $("#pesan").html("Password tidak sama!");
            setTimeout(function() {
                $("#div-alert").fadeOut();
            }, 2000);
        } else {

            const data = {
                id_user: id_user,
                new_pass: new_pass,
            };
            $.ajax({
                url: 'update_password.php',
                type: 'POST',
                data: data,
                success: function(data) {
                    $("#div-alert").fadeIn();
                    $("#div-alert").addClass("alert-success show");
                    $("#pesan").html(data);
                    setTimeout(function() {
                        $("#div-alert").fadeOut();
                    }, 2000);
                }
            });

            $('form')[0].reset();
        }

    });
</script>
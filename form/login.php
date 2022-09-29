<?php

require_once "Validate.php";
$objValidate = new Validate();

if (isset($_POST['login'])){
    $respon = $objValidate->login($_POST);

    if ($respon['status']){
        $_SESSION['alert'] = $respon['message'];
        $_SESSION['pesan_code'] = $respon['pesan_code'];
    }else{
        $_SESSION['alert'] = $respon['message'];
        $_SESSION['pesan_code'] = $respon['pesan_code'];
        header("location:?");
    }
}

?>

<div class="container">
    <div class="row justify-content-end m-2">
        <div class="alert alert-dismissible fade position-absolute" id="div-alert" role="alert" style="z-index: 1;">
            <small id="pesan"></small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <div class="row d-flex justify-content-center align-items-center" style="height: 600px;">
        <div class="card">
            <div class="row">
                <div class="col-md-auto d-flex justify-content-center align-items-center">
                    <img src="../../ac/assets/icons/EPP.png" class="img-fluid rounded-start" alt="" srcset=""
                        width="150" height="150">
                </div>
                <!-- <span class="border-left"></span> -->
                <div class="col-md-auto">
                    <h1 class="text-center mt-1">Login</h1>
                    <div class="card-body">
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <div class="mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-light">
                                            <i class="fa fa-user icon"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="userId" id="" placeholder="Email"
                                        required>
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-light">
                                            <i class="fa fa-lock icon" style="font-size: 19px;"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control" name="userPasswd" id="inputpassowrd"
                                        placeholder="Password" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-light"><i class="fas fa-eye-slash"
                                                id="btn-passwd"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="input-group">
                                    <a href="?page=reset"><small>Lupa password ?</small></a>
                                </div>
                            </div>
                            <div class="input-group">
                                <button type="submit" name="login" class="btn btn-primary mr-3">Kirim</button>
                                <button type="reset" class="btn btn-outline-warning">Set Ulang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#btn-passwd").click(function() {
    if ($(this).attr("class") == "fas fa-eye-slash") {
        $(this).attr("class", "fas fa-eye");
        $("#inputpassowrd").attr("type", "text");
    } else {
        $(this).attr("class", "fas fa-eye-slash");
        $("#inputpassowrd").attr("type", "password");
    }
});

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
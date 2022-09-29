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
        <div class="col-sm-6">
            <div class="card">
                <div class="row">
                    <div class="col-md-auto d-flex justify-content-center align-items-center">
                        <img src="../../mpti/assets/images/logo.png" class="img-fluid rounded-start" alt="" srcset=""
                            width="150" height="150">
                    </div>
                    <span class="border-left"></span>
                    <div class="col">
                        <h3 class="mb-1 text-center">Reset Password</h3>
                        <div class="card-body">
                            <form action="./proses/validate.php" method="POST" class="needs-validation" novalidate>
                                <div class="mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-light">
                                                <i class="fa fa-user icon"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="userId" id=""
                                            placeholder="NIS atau Email" required>
                                        <div class="invalid-feedback">
                                            Tolong isi Email atau NIS anda.
                                        </div>
                                    </div>
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        Masukkan email atau nis anda, kode akan dikirim melalui nomer yang telah
                                        tercatat di akun anda.
                                    </small>
                                </div>
                                <div class="input-group">
                                    <button type="submit" name="login" class="btn btn-primary mr-3">Kirim</button>
                                    <a href="?" class="btn btn-outline-dark">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
setInterval(function() {
    $("#div-alert").addClass("show");
    $("#div-alert").fadeOut();
}, 7000);

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
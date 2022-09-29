<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title><?= (isset($_SESSION['title'])) ? $_SESSION['title'] : null ?></title>
</head>

<body>
    <div class="container">
        <div class="d-flex flex-row-reverse mt-3">
            <div class="position-absolute <?php if(isset($_SESSION['pesan_code'])) { if ($_SESSION['pesan_code'] == 200) {echo "alert-primary"; } 
        else if ($_SESSION['pesan_code'] == 201) {echo "alert-warning"; } 
        else if ($_SESSION['pesan_code'] == 407) {echo "alert-danger"; }}  ?> alert fade <?= isset($_SESSION['alert']) ? 'show' : null ?>"
                id="alert" role="alert" style="z-index: 1;">
                <?= $_SESSION['alert'] ?></div>
        </div>
        <?php 
        $_SESSION['alert'] = null;
        $_SESSION['pesan_code'] = null;
    ?>
        <?php
        if (isset($_GET['page'])){
            if ($_GET['page'] == "reset"){
                $_SESSION['title'] = "Welcome to Login Page";
                include "./form/reset_password.php";
            }
        }else{
            $_SESSION['title'] = "Lupa Password";
            include "./form/login.php";
        }
    ?>

    </div>
</body>
<script>
setInterval(function() {
    $("#alert").each(function(index, elem) {
        var classOfAlert = elem.classList.value.split(' ');

        if (classOfAlert.includes("show")) {
            setTimeout(function() {
                elem.classList.remove("show");
            }, 3000);
        }
    });

}, 1000);
</script>

</html>
<?php

?>
<!DOCTYPE html>
<html style="width:auto;margin:auto;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GavelGo</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
</head>

<body>
    <div class="contact-clean">
        <form method="post">
            <h2 class="text-center">Contact Us</h2>
            <div class="form-group has-success has-feedback"><input class="form-control" type="text" name="name" placeholder="Name"><i class="form-control-feedback glyphicon glyphicon-ok" aria-hidden="true"></i></div>
            <div class="form-group has-error has-feedback"><input class="form-control" type="email" name="email" placeholder="Email"><i class="form-control-feedback glyphicon glyphicon-remove" aria-hidden="true"></i>
                <p class="help-block">Please enter a correct email address.</p>
            </div>
            <div class="form-group"><textarea class="form-control" rows="14" name="message" placeholder="Message"></textarea></div>
            <div class="form-group"><button class="btn btn-primary" type="submit">send </button></div>
        </form>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html style="width:auto;margin:auto;">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GavelGo</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
</head>

<body>
    <div class="login-clean" style="border-top:2px solid rgba(0,0,0,0.03);">
        <form action="/login" method="POST">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-navigate"></i></div>
            <div class="form-group">
            <input class="form-control" type="email" name="user_email" placeholder="Email"></div>

            <div class="form-group">
            <input class="form-control" type="password" name="user_password" placeholder="Password"></div>

            <div class="form-group">
            <!-- <button class="btn btn-primary btn-block" type="submit" style="margin:30px 0px 0px 0px;">Log In</button> -->
            <input type="submit" name="submit" value="Log in">
        </div><a href="/register" class="forgot">Not a member?</a></form>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
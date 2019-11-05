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
    <div>
        <div class="row register-form" style="background:#f1f7fc;border-top:2px solid rgba(0,0,0,0.03);">
            <!-- <form action="/submit" method="POST">
              First name:<br>
              <input type="text" name="firstname" value="Mickey"><br>
              Last name:<br>
              <input type="text" name="lastname" value="Mouse"><br><br>
              <input type="submit" value="Submit">
            </form> -->
            <div class="col-md-8 col-md-offset-2">
                <form action="/register" method="POST" class="form-horizontal custom-form">
                    <h1>Register an Account</h1>
                    <div class="form-group">
                        <div class="col-sm-4 label-column"><label class="control-label" for="name-input-field">First Name </label></div>
                        <div class="col-sm-6 input-column">
                        <input class="form-control" id="user_first_name" name="user_first_name" type="text"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column"><label class="control-label" for="name-input-field">Last Name </label></div>
                        <div class="col-sm-6 input-column">
                        <input class="form-control" id="user_last_name" name="user_last_name" type="text"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column"><label class="control-label" for="email-input-field">Email </label></div>
                        <div class="col-sm-6 input-column">
                        <input class="form-control" id="user_email" name="user_email" type="email"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column"><label class="control-label" for="pawssword-input-field">Password </label></div>
                        <div class="col-sm-6 input-column">
                        <input class="form-control" id="user_password" name="user_password" type="password"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column"><label class="control-label" for="repeat-pawssword-input-field">Repeat Password </label></div>
                        <div class="col-sm-6 input-column"><input class="form-control" type="password"></div>
                    </div>
                    <div class="checkbox"><label><input type="checkbox">I've read and accept the <a href="/terms">terms and conditions</a>.</label></div>
                    <!--<button class="btn btn-default submit-button" type="submit">Register</button></form>-->
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
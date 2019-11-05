<?php
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/fonts/material-icons.css">
    <link rel="stylesheet" href="../../assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
    <link rel="stylesheet" href="../../assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="../../assets/css/Navigation-with-Button1.css">
    <link rel="stylesheet" href="../../assets/css/Simple-Slider.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/Testimonials.css">
    <link rel="stylesheet" href="../../assets/css/Pretty-Product-List.css">
    <link rel="stylesheet" href="../../assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="../../assets/css/Pretty-Search-Form.css">
    <link rel="stylesheet" href="../../assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="../../assets/css/Pretty-Header.css">
    <link rel="stylesheet" href="../../assets/css/Pretty-Login-Form.css">
</head>

<body>
    <div class="container">
        <div style="height:80px;"></div>
        <div class="bs-docs-section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="well bs-component">
                        <form action="" method="POST" id="registerForm" class="form-horizontal">
                            <fieldset>
                                <legend>Register</legend>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Company Name(*)</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="provider_name" type="text" placeholder="" id="inputEmail" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Account(Private) Email(*)</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="account_email" type="text" placeholder="" id="inputEmail" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-lg-2 control-label">Password(*)</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="account_password" type="password" placeholder="" id="inputPassword" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-lg-2 control-label">Confirm Password(*)</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="confirm_password" type="password" placeholder="" id="inputPassword" required="required">
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="agreement" type="checkbox" required="required">On behalf of my organization, I agree to the <strong><em>Terms &amp; Conditions(*)</em></strong> of service.</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2" id="aga02">
                                        <button class="btn btn-primary" name="submit" type="submit" style="margin:0px;">Submit</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
<?php
# create default empty values for session variables to be filled on login:
if(!isset($_SESSION['logged_in'])){
    $_SESSION['logged_in'] = 0;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/material-icons.css">
    <link rel="stylesheet" href="/assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
    <link rel="stylesheet" href="/assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="/assets/css/Navigation-with-Button1.css">
    <link rel="stylesheet" href="/assets/css/Simple-Slider.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/Testimonials.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Product-List.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Search-Form.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Header.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Login-Form.css">
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="<?php echo ROOT_URL;?>">GavelGo Admin Panel</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main" type="buttton"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-main">
                <?php
                if($_SESSION['logged_in'] === 1){
?>
                    <ul class="nav navbar-nav">
                        <li class="active" role="presentation"><a href="<?php echo CUST_ROOT_URL;?>">Main Site </a></li>
                        <li role="presentation"><a href="<?php echo PART_ROOT_URL;?>">Partners Site </a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation">
                            <a href="/logout">
                                <button class="btn btn-primary btn-xs" type="button" style="margin:0px;">Log Out</button>
                            </a>
                        </li>
                    </ul>
<?php
                }
                else {
?>
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation">
                            <a href="/login">
                                <button class="btn btn-primary btn-xs" type="button" style="margin:0px;">Log In</button>
                            </a>
                        </li>
                    </ul>
<?php
                }
?>
        </div>
    </nav>
    
<br /><br /><br /><br />
<?php

if(SessionManager::is_activity_suspicious()){
?>
<script type="text/javascript">
    alert("Logged out due to suspicious activity. This action has been logged for security reasons, but feel free to log in again.");
    // is_activity_suspicious cleared and deleted session, so redirect to login page
    window.location = "/login";
</script>
<?php
}
else {
    Messages::display();
    if(file_exists($view)){
        require($view);
    }
    else {
        echo "<h2>No page</h2>";
    }
}
?>
</body>
</html>
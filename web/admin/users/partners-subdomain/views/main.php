<?php
# create default empty values for session variables to be filled on login:
if(!isset($_SESSION['logged_in'])){
    $_SESSION['logged_in'] = 0;
}
# update last activity time on each request
$_SESSION['_USER_LAST_ACTIVITY'] = time();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GavelGo</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="/assets/css/styles.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body >
    <!-- force reload on refresh or back button press: -->
    <input type="hidden" id="refresh" value="no">
    <script type="text/javascript">
        //$(document).ready(function(e) {
            // Test:
            //alert("reload");
            //window.location.reload(true);
            //var $input = $('#refresh');
            // Test:
            //alert("reload");
            //$input.val() == 'yes' ? window.location.reload(true) : $input.val('yes');
            $(window).bind("pageshow", function(event) {
                if (event.originalEvent.persisted) {
                    window.location.reload(true); 
                }
            });
        //});
    </script>
    
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="/">GavelGo Partners</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main" type="buttton"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-main">
                <ul class="nav navbar-nav">
                    <li role="presentation"><a href="/listings">Listings </a></li>
                </ul>
                <?php 
                if($_SESSION['logged_in'] === 0){
?>
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation"><a href="/register">Register</a></li>
                        <li role="presentation">
                            <a href="/login">
                                <button class="btn btn-primary btn-xs" type="button" style="margin:0px;">Log In</button>
                            </a>
                        </li>
                    </ul>
<?php
                }
                else {
?>
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation"><a href="/account">Account</a></li>
                        <li role="presentation"><a href="/profile">Profile</a></li>
                        <li role="presentation"><a href="/analytics">Analytics</a></li>
                        <li role="presentation">
                            <a href="/logout">
                                <button class="btn btn-primary btn-xs" type="button" style="margin:0px;">Log Out</button>
                            </a>
                        </li>
                    </ul>
<?php
                }
?>
            </div>
        </div>
    </nav>
    
<br /><br /><br /><br />
<?php 
Messages::display();

# since user and partner sites share all controllers, models but not all views, a URL for a view only the user site has will be valid, so check if file exists within document root: 
if(file_exists($view)){    
    require($view);
}
else {
    require("views/home/notfound.php");
}
?>


    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <footer id="footer">
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <li class="pull-right"><a href="#top">Back to top ↺</a></li>
                    <li></li>
                    <li><a href="/support">Support </a><a href="/feedback"> Feedback </a></li>
                </ul>
                <p>Copyright <strong>©</strong> 2017 Dan Van Bueren on behalf of GavelGo (BidPuppy Intl., Inc.)</p>
            </div>
        </div>
    </footer>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="/assets/js/Simple-Slider.js"></script>
</body>
</html>
<?php
//test
#$_SESSION['logged_in'] = 1;
#$_SESSION['user_id'] = 15;
// default values for session variables to be filled on login
if(!isset($_SESSION['logged_in'])){
    $_SESSION['logged_in'] = 0;
}

# update last activity time on each request
$_SESSION['_USER_LAST_ACTIVITY'] = time();
$_SESSION['user_type'] = 'USER';
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>GavelGo</title>
<link rel="icon" type="image/png" href="../assets/img/gav.png"
    sizes="16x16" />
<!-- Bootstrap CSS CDN -->
<!-- Our Custom CSS -->
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">
<link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

<!-- Font Awesome JS -->
<link rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
    integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../../partners-subdomain/assets/js/universalAjax.js"></script>
<script type="text/javascript" src="../../partners-subdomain/assets/js/textCounter.js"></script>
<!-- pubsub -->
<script src="https://rawgit.com/cboden/fcae978cfc016d506639c5241f94e772/raw/e974ce895df527c83b8e010124a034cfcf6c9f4b/autobahn.js"></script>
<script src="/partners-subdomain/assets/js/pubsub.js"></script>

<?php
// pubsub connection
$notifications = array();
$subscriptions = array();
if ($_SESSION['logged_in'] === 1 && isset($_SESSION['user_id'])) {
    $notifications = PartnerDomain\Notification::getNotifications($_SESSION['user_id'], true, 5);
    $subscriptions = PartnerDomain\Notification::getUserNotificationSubscriptions($_SESSION['user_id']);
?>
<script type="text/javascript">
    connectUser('<?php echo WEBSOCKET_ENDPOINT; ?>', 
                "<?php echo $_SESSION['user_id'];?>", 
                <?php echo json_encode($subscriptions['coupons']); ?>, 
                <?php echo json_encode($subscriptions['auctions']); ?>,
                <?php echo json_encode($subscriptions['partners']); ?>,
                "<?php echo NEW_NOTIFICATION_ELEMENT; ?>"); 
</script>
<?php
}
?>
</head>


<style>
a:hover {
    color: #109a48 !important;
}

.comColor {
    color: #109a48 !important;
}

.input-icon {
    position: absolute;
    color: #109a48;
    padding-left: 5px !important;
}

#isearch {
    padding-left: 30px !important;
}

.input-wrapper {
    position: relative;
}

.pop a {
    color: #a0a7b2;
    text-decoration: none;
    font-size: 15px;
}

.headfont {
    font-size: 0.8em; 
    font-weight: 500;
}
.headspace {
    padding-right: 15px;
    padding-top: 1%;
}
.containerdiv {
    background: #f8f9fa !important;
}

.dropdown-menu {
  left: 2.65%;
  transform: translateX(-44.8%);
  padding: 0;
  width: 400px !important;
  border : none !important;
  
}

.dropdown-header {
  background-color: #B37DF7 !important;
  height: 70%;
  padding: 1.3rem 1.5rem !important; 
  color: #F7F8FA !important;
  font-size: 1.2rem !important;
  border: none;
}

.dropdown-menu a:hover {
background-color: #EEF2FB !important;
}


.dropdown-menu a:hover { 
 background-color: #EEF2FB !important; 
 } 
 
 .title {
    width: 99%;
    background: #109a48;
    text-align: center;
    padding: 3% ;
    margin: 2px; 
    color: white;
    position: relative;
    display: flex;
    justify-content: center; 
    text-transform: uppercase;
    letter-spacing: .12em;
}

.title:before { 
    position : absolute;
    top: -10px;
    content: '';
    border-bottom: 12px solid #109a48;
    border-left: 11px solid transparent;
    border-right: 11px solid transparent;
}

.icon {
    background: #109a48;
    color: white;
    padding: 5px;
    border-radius: 50%;
    margin: 5px;
    font-size: 13px;
}

.notification {
    margin: 2px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #F9FDFE;
    width: 99%;
    padding: 0% 5px;
    height: 50px;
}

.alert {
    display: flex;
    align-items: center;
    color: #7D8B94;
    padding-top: 25px;
}

.alert-time {
    padding-bottom: 5px;
    color: #CED0D1;
}

.alert-name {
 font-weight: bold;
}


.title-foot {
    width: 99%;
    background: #EEF0E4;
    text-align: center;
    padding: 3% ;
    margin: 2px; 
    color: white;
    position: relative;
    display: flex;
    justify-content: center; 
    text-transform: uppercase;
    letter-spacing: .05em;
}


@media ( max-width : 700px) {
    .container {
        display: block;
        width: 100%;
    }
    .notification, .title {
        box-sizing: border-box;
    }
    .notification, .title {
        width: 100%;
        margin: 5px 0;
    }
}

a {
   text-decoration: none;
} 

/* Footer */
@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
section {
    padding: 30px 0;
}
section .section-title {
    text-align: center;
    color: #007b5e;
    margin-bottom: 50px;
    text-transform: uppercase;
}
#footer {
    background: #1C2331 !important;
}
#footer h5{
    padding-bottom: 6px;
    margin-bottom: 20px;
    color:#ffffff;
}
#footer a {
    color: #ffffff;
    text-decoration: none !important;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}
#footer ul.social li{
    padding: 3px 0;
}
#footer ul.social li a i {
    margin-right: 5px;
    font-size:25px;
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
}
#footer ul.social li:hover a i {
    font-size:30px;
    margin-top:-10px;
}
#footer ul.social li a,
#footer ul.quick-links li a{
    color:#ffffff;
}
#footer ul.social li a:hover{
    color:#eeeeee;
}
#footer ul.quick-links li{
    padding: 3px 0;
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
}
#footer ul.quick-links li:hover{
    padding: 3px 0;
    margin-left:5px;
    font-weight:700;
}
#footer ul.quick-links li a i{
    margin-right: 5px;
}
#footer ul.quick-links li:hover a i {
    font-weight: 700;
}
@media (max-width:767px){
    #footer h5 {
    padding-left: 0;
    border-left: transparent;
    padding-bottom: 0px;
    margin-bottom: 10px;
}
}
</style>

</head>
<body>
<div class="containerdiv fixed-top">
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">
  <img src="../assets/img/logo_site.png" style="height: 20px; padding-left: -5px;"></a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="padding-top: 1%;">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item headspace">
        <span class="headfont"><a class="nav-link" href="/explore">EXPLORE</a></span>
      </li>
      <li class="nav-item headspace">
        <span class="headfont"><a class="nav-link" href="/coupons">COUPONS</a></span>
      </li>
      <li class="nav-item headspace" style="padding-right: 80px;">
        <span class="headfont"><a class="nav-link" href="/auctions">AUCTIONS</a></span>
      </li>
      <li class="nav-item" style="padding-top: .75%;">
        <form action="/search?q=asdf" class="form-inline" >
            <input id="isearch" class="form-control" placeholder="Search" style="width: 350px;"> 
            <label  for="isearch" class="fas fa-search input-icon"></label>
        </form>
      </li>
      <li class="nav-item headspace">
        <div class="dropdown">
            <button class="btn btn-seccess" type="button"
                id="notificationButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"
                style="background-color: transparent; border: none; box-shadow: none;">
                <i class="fa fa-bell" style="font-size: 20px; color: #139b48"></i>
                <span class="badge badge-pill badge-danger align-top" id="notificationCount" style="position: absolute; font-size:10px; top:1px; left:20px;"></span>
            </button>
                <div class="dropdown-menu" id="notificationDropdown" aria-labelledby="notificationButton">
                    <h6 class="title">Notifications</h6>
                    <div id="notificationItems">   
                    </div>
                    <h6 class="title-foot"><a href="/notifications">View All</a></h6>
                </div>
        </div>
      </li>
      <li class="nav-item">
<?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
            $fullname = $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
?>
            <button type="button" class="btn" style="background-color:transparent; color: #109a48 !important; box-shadow: none;"
                            data-container="body" data-toggle="popover" data-trigger="focus"
                            data-placement="bottom" title=""
                            id="target"><img src="../assets/img/profile-pic.png"
                            style="width: 35px; border-radius: 60%;"><span style="padding-left: 8%;"><?php echo $fullname?></span><span style="padding-left: 10%;"><i
                            class="fas fa-angle-down"></i></span>
            </button>

<?
        }
        else {
?>
            <a href="/login" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Log in</a>       
<?php
        }
?>
      </li>
    </ul>
    
  </div>
</nav>
</div>
</div>

<!-- update notifications element down here after div made above-->
<script type="text/javascript">
    var notifications = <?php echo json_encode($notifications, JSON_FORCE_OBJECT);?>;
    notifications = formatNotificationDateTimes(notifications);
    var unreadNotificationsCount = <?php echo PartnerDomain\Notification::getUnreadNotificationsCount($_SESSION['user_id']); ?>;

    if (unreadNotificationsCount > 0) {
        $("#notificationCount").html(unreadNotificationsCount);
    }

    var dropdown = $('#notificationItems')

    for (const key in notifications) {
        var notification = notifications[key]
        console.log(notification)
        // change icon based on type - integration branch
        // change background and text color based on read/unread status
        backgroundColor = ""
        textColor = ""
        if (notification.is_read == 0) {
            backgroundColor = "bg-secondary"
            textColor = "text-white"
        }

        dropdown.append("\
           <div class=\"notification " + backgroundColor + "\" onclick=\"followNotificationLink(notification.link, notification.id, notification.user_id, notification.is_read); \">\
                    <div class=\"alert\">\
                        <i class=\"fas fa-pen\"></i>\
                        <div class=\"alert-content " + textColor + "\">\
                                <span style=\"padding-left: 5px; class=\"alert-name\">" + notification.body + "</span>\
                        </div>\
                    </div>\
                <div class=\"alert-time\">" + notification.timeDifference + "</div>\
            </div>\
        ")
    }
</script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(function () {
              $('[data-toggle="popover"]').popover()
        });

        var profile = document.createElement('div')
        profile.innerHTML = '<div class="pop"><a href="/profile"><span><i class="fas fa-cog"></i></span><span style="padding-left: 15px; padding-right: 90px;"> Settings</span></a></div>    <div class="pop"><a href="/logout"><span><i class="fas fa-sign-out-alt"></i></span><span style="padding-left: 15px; padding-right: 90px;"> Log Out</span><span style="padding-left: 15px; "></span></a></div>';
        $('#target').popover({
            content: profile,
            html: true
        });

        $("#notificationButton").click(function(){
            $("#noti").css("display", "none");
        });

    </script>
<!-- end header -->
<?php
PartnerDomain\Messages::display();
// This is the main content of the page
require($view);
?>
<!-- Footer -->
    <section id="footer">
        <div class="container">
            <div class="row text-center text-xs-center text-sm-left text-md-left">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <h5>GavelGo</h5>
                    <ul class="list-unstyled quick-links">
                        <li><a href="javascript:void();">About Us</a></li>
                        <li><a href="javascript:void();">Company</a></li>
                        <li><a href="javascript:void();">Careers</a></li>
                        <li><a href="javascript:void();">Get Help</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <h5>More Info</h5>
                    <ul class="list-unstyled quick-links">
                        <li><a href="javascript:void();">How It's Done</a></li>
                        <li><a href="javascript:void();">Mobile Apps</a></li>
                        <li><a href="javascript:void();">Staying Safe</a></li>
                        <li><a href="javascript:void();">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <h5>Partners</h5>
                    <ul class="list-unstyled quick-links">
                        <li><a href="javascript:void();">Apply For Membership</a></li>
                        <li><a href="javascript:void();">Learn More</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <ul class="list-unstyled list-inline social text-center">
                        <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-google-plus"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void();" target="_blank"><i class="fa fa-envelope"></i></a></li>
                    </ul>
                </div>
            </div>  
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                    <p>GavelGo Intl., Inc</p>
                    <p class="h6">&copy; All right Reversed.</p>
                </div>
            </div>  
        </div>
    </section>
    <!-- ./Footer -->
</body>
</html>
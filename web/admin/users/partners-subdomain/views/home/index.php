<?php
Messages::display();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gavelgo | Home</title>
</head>
<body>
<div class="container">
        <div style="height:80px;"></div>
        <div id="banner" class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bs-component">
                        <div class="jumbotron">
                            <h1 style="padding-top: 0;">Welcome to Partners.</h1>
                            <p>Welcome to the Partners Portal - your one stop shop for anything and everything account and profile management related. </p>
                            <p><a class="btn btn-primary btn-lg" role="button" href="/listings">Manage Your Listings</a></p>
                        </div>
<?php
                        if($_SESSION['logged_in'] === 1){
?>
                            <h2><a href="/coupons/add">Add a Coupon</a></h2>
                            <h2><a href="/products/add">Add a Product/Deal</a></h2>
                            <h2><a href="/auctions">All Auctions</a></h2>
<?php
                        }
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

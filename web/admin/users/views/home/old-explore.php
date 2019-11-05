<?php
use PartnerDomain\Model;
?>
<!DOCTYPE html>
<html style="width:auto;margin:auto;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GavelGo</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="/assets/css/styles.min.css">
</head>

<body>
    <div class="highlight-phone" style="background:#f1f7fc;box-shadow:0px 0px 10px -2px;">
        <div class="container">
            <div class="row" style="margin:-20px 0px -60px 0px;">
                <div>
                    <div class="intro">
                        <h2 style="margin:0px;">Explore</h2>
                        <h5 style="margin:0px 0px 40px;opacity:0.75;">{tags}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    $coupons  = $request_data['coupons'];
    $auctions = $request_data['auctions'];
?>
    <div class="highlight-phone" style="background:#ffffff;border-top:2px solid rgba(193,198,202,0.16);padding:50px 0px 0px 0px;">
        <div style="margin:-30px 26px 0px 26px;">
            <div class="row product-list">
        <p>COUPONS</p>
<?php
    foreach ($coupons as $key => $coupon) {
?>
        <div class="col-md-4 col-sm-6 product-item">
            <div class="product-container">
                <div class="row">
                    <div class="col-md-12"><a href="#" class="product-image"><img src="<?php echo '/assets/img/' . $coupon->photo . '.jpg'?>"></a></div>
                </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <h2><a href="<?php echo "/coupons/" . Model::encode_name($coupon->provider_name) . "/" . Model::encode_name($coupon->id); ?>"><?php echo $coupon->title?></a></h2>
                        </div>
                        <!-- name of provider and link to profile -->
                        <div class="col-xs-4"><a href="<?php echo "/providers/" . Model::encode_name($coupon->provider_name)?>" class="small-text"><?php echo $coupon->provider_name?></a></div>
                        <!-- name of category and link to profile -->
                        <div class="col-xs-4"><a href="<?php echo '/categories/' . Model::encode_name($coupon->category_name)?>" class="small-text"><?php echo $coupon->category_name?></a></div>
                    </div>
                    <div class="product-rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half"></i><a href="#" class="small-text">82 reviews</a></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="product-description"><?php echo $coupon->description?> </p>
                            <div class="row">
                                <div class="col-xs-6"><button class="btn btn-default" type="button">Redeem</button></div>
                                <div class="col-xs-6">
                                    <p class="product-price">$cost </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php 
    }
?>  
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <p>AUCTIONS</p>
        <div style="margin:26px;">
            <div class="row product-list">
<?php
    foreach ($auctions as $key => $auction) {
        foreach ($auction as $k => $v) {
?>      
        <div class="col-md-4 col-sm-6 product-item">
            <div class="product-container">
                <div class="row">
                    <div class="col-md-12"><a href="#" class="product-image"><img src="/assets/img/gavel1.jpg"></a></div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <h2><a href="#"><?php echo $v['bid_title']?></a></h2>
                    </div>
                    <div class="col-xs-4"><a href="#" class="small-text"><?php echo "name"?></a></div>
                </div>
                <div class="product-rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half"></i><a href="#" class="small-text">82 reviews</a></div>
                <div class="row">
                    <div class="col-xs-12">
                        <p class="product-description"><?php echo $v['bid_description']?></p>
                        <div class="row">
                            <div class="col-xs-6"><button class="btn btn-default" type="button">Bid</button></div>
                            <div class="col-xs-6">
                                <p class="product-price">$<?php echo $v['bid_cost']?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        }
    }
?>  
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
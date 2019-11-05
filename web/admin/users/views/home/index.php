<?php
?>
<!DOCTYPE html>
<html style="width:auto;margin:auto;">

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/gav.png" sizes="16x16" />
    <title>GavelGo</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="/assets/css/styles.min.css">


<style>
.blog {
    background: #FBFEF9;
    padding: 1%;
    box-shadow: 2px 2px 1px #F4F7F3;
}
.blog .carousel-indicators {
    left: 0;
    top: auto;
    bottom: -40px;
}
/* The colour of the indicators */
.blog .carousel-indicators li {
    background: #a3a3a3;
    border-radius: 50%;
    width: 8px;
    height: 8px;
}
.blog .carousel-indicators .active {
    background: #37A000;
}
.imageCarousel {
    max-width: 100%;
    border-radius: 10px;
    height: 90%;
    width: 100%;
}
</style>

<noscript>JavaScript is off. Please enable to view full site.</noscript>

</head>
<body>
    <div>
        <div class="header-blue" style="padding:5px 0px 30px 0px;border-top:2px solid rgba(0,0,0,0.25);">
            <div class="container hero">
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-1 col-md-6" style="padding-left:30px;">
                        <h1>Welcome to GavelGo.</h1>
                        <p>GavelGo is the number one platform for service providers and consumers. Promote your business or search for services and compare all the best businesses in your area!</p><a class="btn btn-default btn-lg action-button" role="button"
                            href="/info">Learn More</a>
                        <form action="/search" method="GET" class="search-form" style="padding:40px 0px 0px 0px;margin:40px 0 0 0 ;">
                            <div class="input-group">
                                <div class="input-group-addon"><span><i class="glyphicon glyphicon-search"></i></span></div><input class="form-control" type="text" name = "q" minlength=2 placeholder="I am looking for.." id="search-field" autocomplete="off">
                                <div class="input-group-btn"><button class="btn btn-default" type="submit">Search </button></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-5 col-lg-offset-0 col-md-5 col-md-offset-1 hidden-xs hidden-sm phone-holder">
                        <div class="iphone-mockup"><img src="../assets/img/iphone.svg" class="device">
                            <div class="screen"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
    <h3 class="comColor">&nbsp;Featured Product:</h3>
            <div class="row blog">
                <div class="col-md-12">
                    <div id="couponCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#couponCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#couponCarousel" data-slide-to="1"></li>
                        </ol>

                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/desk.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <br>
    <br>
    <br>
</body>
</html>
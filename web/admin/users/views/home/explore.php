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
    
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>


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

.imageCarousel{
    max-width:100%; 
    border-radius: 10px;
}
</style>

<body>
<?php
// use these to calculate size of carousels
$couponCount   = sizeof($view_model['coupons']);
$auctionCount  = sizeof($view_model['auctions']);
$partnerCount  = sizeof($view_model['partners']);
$categoryCount = sizeof($view_model['categories']);
?>
    <div class="container" style="padding-top: 8%;">
            <h4 class="comColor">Coupons</h4>
            <div class="row blog">
                <div class="col-md-12">
                    <div id="blogCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#blogCarousel" data-slide-to="1"></li>
                        </ol>

                        <!-- Carousel items -->
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/e3/86/d2/e386d248ce1f4b047c11180033a2ded5.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/e3/86/d2/e386d248ce1f4b047c11180033a2ded5.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/e3/86/d2/e386d248ce1f4b047c11180033a2ded5.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/e3/86/d2/e386d248ce1f4b047c11180033a2ded5.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/e3/86/d2/e386d248ce1f4b047c11180033a2ded5.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/e3/86/d2/e386d248ce1f4b047c11180033a2ded5.jpg" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                        </div>
                        <!--.carousel-inner-->
                    </div>
                    <!--.Carousel-->

                </div>
            </div>
            
            <br>
            <h4 class="comColor">Auctions</h4>
            <div class="row blog">
                <div class="col-md-12">
                    <div id="blogCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#blogCarousel" data-slide-to="1"></li>
                        </ol>

                        <!-- Carousel items -->
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="row">
<?php
                                    foreach ($view_model['auctions'] as $key => $auction) {
?>
                                        <div class="col-md-2">
                                            <a href="#">
                                                <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                            </a>
                                        </div>
<?php
                                    }
?>                
<?php

?>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                        </div>
                        <!--.carousel-inner-->
                    </div>
                    <!--.Carousel-->

                </div>
            </div>
            
            <br>
            <h4 class="comColor">Providers</h4>
            <div class="row blog">
                <div class="col-md-12">
                    <div id="blogCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#blogCarousel" data-slide-to="1"></li>
                        </ol>

                        <!-- Carousel items -->
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="http://placehold.it/180x180" alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                        </div>
                        <!--.carousel-inner-->
                    </div>
                    <!--.Carousel-->

                </div>
            </div>
</div>
<br><br>
    <script type="text/javascript">
    $('#blogCarousel').carousel({
        interval: 5000
    });
    </script>
</body>

</html>
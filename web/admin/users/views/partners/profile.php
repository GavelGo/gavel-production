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
    height: 90%;
    width: 100%;
}

.cover {
    position: relative;
	width: 1100px;
	height: 450px;
	overflow: hidden;
	background-color: white;
	margin-left:16px;
}

.cover #profile {
	width: 100%; 
	height: 60%;
	object-fit: cover;
}

.cover #img-left {
  position: absolute;
  top: 55%;
  left: 10%;
  transform: translate(-50%, -50%);
  text-align: center;
  z-index: 3;
  width: 250px;
  border-radius: 50%;
  border: 8px solid #ECEFDC;
}

.cover #img-right {
  position: absolute;
  top: 55%;
  left: 90%;
  transform: translate(-50%, -50%);
  text-align: center;
  width: 250px;
  height:250px;
  z-index: 3;
  border-radius: 80%;
  border: 8px solid #ECEFDC;
}


.vertical {
  border-left: 2px solid #80817B;
  height: 220px;
  position: absolute;
  top: 63%;
}

.provider {
  position: absolute;
  top: 50%;
  text-transform: uppercase;
  color: #D8DACF;
  text-align: justify;
  font-size: 20px;
}
.desciption {
  position: absolute;
  top: 63%;
  width: 220px;
  height: 100px;
}

i.far {
  display: inline-block;
  border-radius: 40px;
  box-shadow: 0px 0px 2px #80817B;
  padding: 0.5em 0.6em;
}

.fast {
  display: inline-block;
  border-radius: 40px;
  box-shadow: 0px 0px 2px #80817B;
  padding: 0.5em 0.6em;
}

.direction-button {
  position: absolute;
  top: 88%;
  width: 220px;
  height: 100px;
}



</style>

<body>
	<div class="container" style="padding-top: 6%;">

		<div class="cover" >
			<img id="profile" src="/partners-subdomain/assets/img/uploads/partners/cover-pic.png" height="100" width="50">
			<img id="img-left" src="../assets/img/profile-pic.png">
			<img id="img-right" src="/partners-subdomain/assets/img/dir.png">
			<div class="provider" style="left: 22%;"><strong> Tarin Construction </strong></div>
			<div class="desciption" style="left: 22%;"><span class="text-secondary"><strong>Bio:</strong> The
								Motorcycles segment consists of HDMC, which designs,
								manufactures and sells at wholesale on-road Harley-Davidson
								motorcycles, as well as motorcycle parts, accessories and services. </span> </div>
			<div class="desciption text-secondary" style="left: 43%; font-size: 17px;"><i class="far fa-envelope"></i></div>
			<div class="desciption text-secondary" style="left: 48%; top: 64%; font-size: 15px;">jess.tarin@gmail.com</div>
			
			<div class="desciption text-secondary" style="left: 43%; top: 75%; font-size: 17px;"><i class="fas fa-phone fast"></i></div>
			<div class="desciption text-secondary" style="left: 48%; top: 76%; font-size: 15px;">(545) 546-4352</div>
			
			<div class="desciption text-secondary" style="left: 43%; top: 87%;font-size: 16px;"><i class="fas fa-tv fast"></i></div>
			<div class="desciption text-secondary" style="left: 48%; top: 88%; font-size: 15px;">www.gavelgo.com</div>
			
			<div class="direction-button" style="left: 65%; top: 88%;"><button type="button" class="btn btn-secondary btn-sm" style="border-radius: 10px; padding-left: 35px; padding-right: 35px;">Get Directions</button></div>
			
			<div class="vertical" style="left: 42%;"></div>
			<div class="vertical" style="left: 64%;"></div>
		</div>
		<br>
		
		<h4 class="comColor">&nbsp; Pictures of the Business:</h4>
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
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <br>
            <h4 class="comColor">&nbsp; Featured Coupons</h4>
            <div class="row blog">
                <div class="col-md-12">
                    <div id="auctionCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#auctionCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#auctionCarousel" data-slide-to="1"></li>
                        </ol>

                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="/coupons">
                                            <img src="/partners-subdomain/assets/img/uploads/partners/provider.jpg"  alt="Image" class="imageCarousel">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           <br>

	</div>
	<script type="text/javascript">
	$('#blogCarousel').carousel({
		interval: 5000
	});
	</script>
</body>

</html>
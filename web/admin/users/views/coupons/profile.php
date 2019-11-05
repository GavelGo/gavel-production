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
</head>


<style>
.div-row {
	width: 84px;
	border-style: ridge;
}

.div-row:hover {
	border-style: solid;
	border-color: #37A000;
}

.bid-img {
	width: 78px;
	height: 61px;
}

.big-img {
	width: 500px;
	height: 400px;
}

.bid-his-row {
	width: 150px;
	text-align: left;
	color:#828fa3;
}

.bid-his-span {
	font-size: 15px; 
	font-weight: bold; 
	padding-right: 5px;
	color:#828fa3;
}

.bid-his-span-child {
	color:#90b4ed;
}

@
fa-cc-amex: #007bc1 ; .fa {
	color: #efefef; &.
	fa-cc-amex {color: @fa-cc-amex;
}

/* Hide the images by default */
.mySlides {
	display: none;
}
</style>

<body class="bg-light">
<?php
if (!is_null($view_model)) {
?>
<div class="container bg-light" style="padding-top: 100px; padding-left: 30px;">
		<h4 class="text-secondary"><?php echo $view_model->title ?></h4><br>
		<div class="row">
			<div class="col-1">
<?php
	foreach ($view_model->photo_basenames as $key => $image) {
		$imageFullPath = "../" . constant("COUPON_IMG_DIR") . $image . constant("IMG_EXTENSION");
		echo "
		<div class=\"div-row\">
			<img class=\"demo cursor bid-img\" src=\"" . $imageFullPath . "\" 
				onclick=\"currentSlide(" . ($key+1) . ")\" onmouseover=\"currentSlide(" . ($key+1) . ")\">
		</div>
		";

	}
?>
			</div>
			<div class="col-6">
<?php
	foreach ($view_model->photo_basenames as $key => $image) {
		$imageFullPath = "../" . constant("COUPON_IMG_DIR") . $image . constant("IMG_EXTENSION");
		echo "
			<div class=\"mySlides\">
			    <img src=\"" . $imageFullPath . "\" class=\"big-img\">
			</div> 
		";
	}
?>
			</div>
			<div class="col-5">
						<div class="col divCol">
							<img src="../assets/img/profile-pic.png"
							style="width: 35px; border-radius: 60%;"> <strong class="text-secondary">&nbsp;&nbsp;<a href="<?php echo "/partners/" . $view_model->partnerHash?>"><?php echo $view_model->partnerName?></a></strong>
							<br>
							<br>
							<span class="text-info">
								<strong>Description</strong>
								<br>
								<?php echo $view_model->description?>
							</span>
								<br>
								<br>
<?php
							if (!is_null($view_model->price)) {
								echo "
								    <span class=\"text-info\">
										<strong>Price</strong>
										<br>
										$" . $view_model->price . " 
									</span>
									<br>
									<br>
								";
							}
?>				
							<span class="text-info">
								<strong>Start Date</strong>
								<br>
								<?php echo $view_model->start_date?>
							</span>
							<br>
							<br>
							<span class="text-info">
								<strong>Expiry Date</strong>
								<br>
								<?php echo $view_model->end_date?>
							</span>
							<br>
							<br>
							<span class="text-info">
								<strong>Restrictions</strong>
								<br>
								<?php echo $view_model->restrictions?>
							</span>
						</div>
			</div>
		</div>
	</div>
	<br>
	

	<script type="text/javascript">

	var slideIndex = 1;
	showSlides(slideIndex);

	// Next/previous controls
	function plusSlides(n) {
	  showSlides(slideIndex += n);
	}

	// Thumbnail image controls
	function currentSlide(n) {
	  showSlides(slideIndex = n);
	}

	function showSlides(n) {
	  var i;
	  var slides = document.getElementsByClassName("mySlides");
	  var dots = document.getElementsByClassName("demo");
	  if (n > slides.length) {slideIndex = 1}
	  if (n < 1) {slideIndex = slides.length}
	  for (i = 0; i < slides.length; i++) {
	    slides[i].style.display = "none";
	  }
	  for (i = 0; i < dots.length; i++) {
	    dots[i].className = dots[i].className.replace(" active", "");
	  }
	  slides[slideIndex-1].style.display = "block";
	  dots[slideIndex-1].className += " active";
	}
	
	</script>
</body>
<?php
}
else {
	// nice message
}
?>
</html>
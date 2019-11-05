<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Provider Profile</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
	// bookmark this provider for current user
	$("#saveButton").click(function(){
			$.ajax({
				type: "POST",
				url: "/user_handler.php",
				data: {
					user_email: "<?php echo $_SESSION['user_email'];?>",
					provider_id: "<?php echo $request_data->id?>",
					token: <?php echo AJAX_TOKEN ?>,
					request: "save_or_unsave_provider"
				},
				success: function(jsonData) {
					alert(jsonData);
					parsedJson = JSON.parse(jsonData);

					if(parsedJson['result'] !== "success"){
						alert("Could not save provider due to server error. Please contact us regarding this issue.");
					}
					else if(parsedJson['result'] === "success"){
						if(parsedJson['saved_or_unsaved'] === 1){
							alert("Provider saved!");
							$('#saveButton').html("Unsave");
						}
						else {
							alert("Provider unsaved!");
							$('#saveButton').html("Save");
						}
					}
				},
				error: function(status){
					alert("Error while submitting review.");
				}
			});
			return false;
	});

	// save review to db and add to top of list on page once submitted
	$("#submitReviewButton").click(function(){
		$.ajax({
			type: "POST",
			url: "/user_handler.php",
			data: {
				user_email: "<?php echo $_SESSION['user_email'];?>",
				provider_id: "<?php echo $request_data->id?>",
				review: $('#reviewTextArea').val(),
				rating: $('#reviewRating').val(), 
				recommendation: $(".rec_radio:checked").val(),
				token: <?php echo AJAX_TOKEN ?>,
				request: "leave_review"
			},
				success: function(jsonData) {
					alert(jsonData);
					
					parsedJson = JSON.parse(jsonData);
					if(parsedJson['result'] !== "success"){
						alert("Could not submit review due to server error. Please contact us regarding this issue.");
					}
					else if(parsedJson['result'] === "success"){
						alert("Review submitted!");
						$('#reviewsDiv').prepend('<p><b>' +  parsedJson['user_name'] + '</b> on <?php echo date('F d, Y'); ?></p><p>' + parsedJson['rating'] + ' stars</p><p>' + parsedJson['review'] + '</p><br /><br />');
					}
					else {
						alert("stuck on pending!");
					}
				},
				error: function(status){
					alert("Error while submitting bid.");
				}
		});
		return false;
	});

	// show review form
	$("#leaveReviewButton").click(function(){
		if($("#leaveReviewForm").is(":visible")){
                $("#leaveReviewForm").hide();
        } else {
            $("#leaveReviewForm").show();
        }
        return false;
	});

	// show contact form
	$("#contactButton").click(function(){
		if($("#contactForm").is(":visible")){
                $("#contactForm").hide();
            } 
            else {
                $("#contactForm").show();
            }
            return false;
	});	
});
</script>
</head>
<style type="text/css">
	/* google map */
	/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
      	height: 25%;
      	width: 15%;
      	top: 300px;
      	left: 75%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 300px;
        left: 76%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #dir-button {
      	position: absolute;
      	top: 610px;
      	left: 75%;
      }
    /* end google map */
</style>
<body>
<!-- google map -->
<?php
  	$addr = $request_data->address_line_one . ' ' . $request_data->address_line_two;
  	?>

    <div id="floating-panel">
      <input id="address" type="textbox" value="<?php echo $db_addr?>">
    </div>
    <div id="map"></div>
    <script>
      function initMap() {
      	// test val, will get real val from db
      	var addr = "<?php echo $db_addr ?>";
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: -34.397, lng: 150.644}
          //center: {lat: 0, lng: 0}
        });
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': addr}, function(results, status) {
          if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    <script async defer
    src=null>
    </script>
    <div id="dir-button">
    	<button><a href="https://www.google.com/maps/dir//<?php echo urlencode($db_addr)?>"target="_blank">Get Directions to here</a></button>
    </div>
<!-- end google map --> 
<?php

# Breadcrumb: 
echo '<h3>Breadcrumb: <a href="/">Home</a> / <a href="/providers">Providers</a></h3>';

	if(!is_null($request_data)){
?>
		<h2>Provider Profile</h2>
		<fieldset>
		<h3><?php echo $request_data->name;?></h3>
		<h4><?php echo $request_data->description;?></h4>
		<h5><?php echo $request_data->address_line_one; ?></h5>
		<h5><?php echo $request_data->address_line_two; ?></h5>
		<br />
<?php 
		if(!empty($request_data->photo_basename)){
?>
		<img src="<?php echo '/assets/img/uploads/providers/' . $request_data->photo_basename . '.png'?>" alt="provider profile picture" style="width:200px;height:200px;">
<?php
		}
		else {
?>
		<img src="/assets/img/uploads/providers/default.png" alt="default provider profile picture" style="width:200px;height:200px;"">
<?php
		}
?>
		<h3>Products</h3>
		<fieldset>
<?php	
		if(!empty($request_data->products)){
			foreach ($request_data->products as &$product) {
				echo '<h3><a href="">' . $product['product_name'] . '</a></h3>';
			}	
		}
		else{
			echo "<br />No Product Listings at this time.";
		}
?>
		</fieldset>
		<br />
		<h3>Coupons</h3>
		<fieldset>
<?php

		if(!empty($request_data->coupons)){
			foreach ($request_data->coupons as &$coupon) {
				echo '<h3><a href="' . CUST_ROOT_URL . 'coupons/' . $coupon['coupon_title'] . '">' . $coupon['coupon_title'] . '</a></h3>';
			}	
		}
		else{
			echo "<br />No Coupon Listings at this time.";
		}
			
?>
		</fieldset>
		<br /><br /><br />
<?php
		# determine content of button for initial page load. Any saves or unsaves of this provider will subsequently change the button display text with js:
		$user = UserModel::get_by_email($_SESSION['user_email']);
		if($user->provider_is_saved($request_data->id) === 0){
?>
			<button id="saveButton">Save</button>
<?php
		}
		else {
?>
			<button id="saveButton">Unsave</button>
<?php
		}
?>
		<br />
		<button id="contactButton">Contact</button>
		<br /><br />
		<form action="" method="POST" id="contactForm" style="display: none">
			<label for="inquiry">Inquiry</label>
			<br />
			<textarea rows="10" cols="20" placeholder="Questions, comments, porposals, requests..."></textarea>
			<br />
			<input type="submit" name="submit" value="Send">
		</form>
		<br /><br />
		<h3>Website:
<?php
		if(!empty($request_data->website)){
?>
			<a href="<?php echo $request_data->website?>"></a>
<?php
		}
		else {
			echo "None";
		}
?>
		</h3>
		<br /><br />
		<h3>Reviews/Feedback</h3>
		<button id="leaveReviewButton" >Leave a Review</button>
		<br /><br />
		<form action="" method="POST" id="leaveReviewForm" style="display: none">
			<textarea rows="5" cols="20" id="reviewTextArea"></textarea>
			<br />
			Rating:
			<br />
			<select id="reviewRating">
				<option disabled="disabled" selected value>-- Rating --</option>
				<option value="1">1 stars</option>
				<option value="2">2 stars</option>
				<option value="3">3 stars</option>
				<option value="4">4 stars</option>
				<option value="5">5 stars</option>
			</select>
			<br /><br />
			Would Recommend: <input type="radio" name="recommendation" class="rec_radio" value="1" />
			<br />
			Would Not Recommend: <input type="radio" name="recommendation" class="rec_radio" value="0" />
			<br /><br />
			<!-- rating, reivew, would recommend, etc.-->
			<input type="button" id="submitReviewButton" name="submit_review" value="Submit">
		</form>
		<br /><br /><br />

		<div id="reviewsDiv">
<?php
		$reviews = $request_data->get_reviews();
		if(!empty($reviews)){
			foreach ($reviews as &$r) {
				$recommendation = "Would " . (($r['provider_review_would_recommend'] === 1)? '': ' not ') . " recommend";
?>
					
					<p><b><?php echo $r['user_first_name'] . ' ' . $r['user_last_name'] . '</b> on ' . date('F d, Y', strtotime($r['provider_review_post_time'])); ?></p>
					<p><?php echo $recommendation ?></p>
					<p><?php echo $r['provider_review_rating'] . ' stars'; ?></p>
					<p><?php echo $r['provider_review_review']; ?></p>
					<br /><br />
<?php
			}
		}
		else {
			echo "No Reviews for this Provider yet";
		}
?>
		</div>
<?php
	}
	else {
		echo "<h2>No Provider found!</h2>";
	}
?>

</body>
</html>

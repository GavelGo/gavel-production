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
	<script type="text/javascript" src="../../partners-subdomain/assets/js/countdown.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#placeBidBtn").click(function(){
				var bid = $("#bidValue").val();
				var currentBid = parseInt($("#currentOfferValue").text().substring(1));
				var minimumIncrement = <?php echo $view_model->minimumIncrement;?>;

				if ($.isNumeric(bid)) {
					// bid is too low
					if (bid < (currentBid + minimumIncrement)) {
						alert("bid too low. please bid at least $" + (currentBid + minimumIncrement));
						return false;
					}

					data = {
							auction_hash: "<?php echo $view_model->hash;?>",
							user_id:      "<?php echo $_SESSION['user_id'];?>",
							bid:          bid,
							action:       "place_bid",
							model:        "auction"
					}

					doAjax("POST", "/partners-subdomain/api/api.php", data).done(function(data) {
						parsedJson = JSON.parse(data)

						if(parsedJson['result'] !== "success"){
							console.log("Could not submit bid due to server error. Please contact us regarding this issue.");
						}
						else if(parsedJson['result'] === "success"){
							var newMinimumOffer = parseInt(bid) + parseInt(minimumIncrement);
							// current offer
							$("#currentOfferValue").text("$" + bid);
							// autofill input form
							$("#bidValue").val(newMinimumOffer);
							// new minimum offer
							$("#minOffer").text("Minimum offer: $" + newMinimumOffer);
						}
						else {
							alert("stuck on pending!");
						}
					});
				}
				return false;
			});

			// get bid history
			$("#historyButton").click(function(){
				var bidHash = "<?php echo $view_model->hash?>";

				data = {
					auction_hash: "<?php echo $view_model->hash;?>",
					action:       "get_bid_history",
					model:        "auction"
				}
				doAjax("POST", "/partners-subdomain/api/api.php", data).done(function(response) {
					parsedResponse = JSON.parse(response);
						
					if(parsedResponse['result'] === "success"){
						$("#historyBidderCount").text(parsedResponse.history.unique_bidders)
						$("#historyBidCount").text(parsedResponse.history.bid_count)

						// clear table so entries aren't duplicated if button pressed multiple times
						$("#bidHistoryItems").html('');

						parsedResponse.history.bids.forEach(function(historyItem) {
							var fullname = historyItem.user_first_name + " " + historyItem.user_last_name;

							$("#bidHistoryItems").append('\
								<tr>\
				                    <td class="bid-his-row">' + fullname + '</td>\
				                    <td class="bid-his-row">$' + historyItem.bid + '</td>\
				                    <td class="bid-his-row">' + historyItem.created + '</td>\
		                        </tr>\
							')
						});
					}
					else {
						console.log("failure: " + response);
					}
				});
			});
		});
	</script>
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
<?php
if (!is_null($view_model)) {
	if (is_null($view_model->currentOffer)) {
		$view_model->currentOffer = $view_model->reservePrice;
	}
?>
<script type="text/javascript">
	startCountdown("<?php echo $view_model->finish;?>", "countdown");
</script>
<body class="bg-light">
<div class="container bg-light" style="padding-top: 100px; padding-left: 30px;">
		<h4 class="text-secondary"><?php echo $view_model->title ?></h4><br>
		<div class="row">
			<div class="col-1">
<?php
	foreach ($view_model->photo_basenames as $key => $image) {
		if ($image != '') {
			$imageFullPath = "../" . constant("AUCTION_IMG_DIR") . $image . constant("IMG_EXTENSION");
			echo "
			<div class=\"div-row\">
				<img class=\"demo cursor bid-img\" src=\"" . $imageFullPath . "\" 
					onclick=\"currentSlide(" . ($key+1) . ")\" onmouseover=\"currentSlide(" . ($key+1) . ")\">
			</div>
			";
		}

	}
?>
			</div>
			<div class="col-6">
<?php
	foreach ($view_model->photo_basenames as $key => $image) {
		if ($image != '') {
			$imageFullPath = "../" . constant("AUCTION_IMG_DIR") . $image . constant("IMG_EXTENSION");
			echo "
				<div class=\"mySlides\">
				    <img src=\"" . $imageFullPath . "\" class=\"big-img\">
				</div> 
			";
		}
	}
?>
			</div>
			<div class="col-5">						
						<div class="col divCol">
							<img src="../assets/img/profile-pic.png"
							style="width: 35px; border-radius: 60%;"> <strong class="text-secondary">&nbsp;&nbsp;<a href="<?php echo "/partners/" . $view_model->partnerHash?>"><?php echo $view_model->partnerName?></a></strong>
							<br>
							<br>
							<div class="row">
								<div class="col" style="background-color: #cbd9ef;">
									<form>
										<table style="margin-top: 5px;">
											<tr>
												<td style="width: 150px; text-align: right;">Current offer:</td>
												<td id="currentOfferValue" style="padding-left: 5px; font-weight: bold;"><?php echo "$" . $view_model->currentOffer;?></td>
												<td>[<button type="button" id="historyButton" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modalBid">History</button>]
												</td>
											</tr>
											<tr>
												<td style="width: 150px; text-align: right;"></td>
												<td style="padding-top: 15px;">
													<input type="text" class="form-control" id="bidValue" value="<?php echo ($view_model->currentOffer + $view_model->minimumIncrement)?>" autocomplete="off">
												</td>
												<td style="padding-top: 15px;"><button class="btn btn-success" id="placeBidBtn">Place Bid</button></td>
											</tr>
											<tr>
												<td></td>
												<td
													id="minOffer" style="padding-top: 5px; font-size: 12px; padding-bottom: 5px;">Minimum offer: $<?php echo ($view_model->currentOffer + $view_model->minimumIncrement)?></td>
												<td></td>
											</tr>
										</table>
									</form>
								</div>
							</div>

							<span class="text-info">
								<strong>Description</strong>
								<br>
								<?php echo $view_model->description?>
							</span>
							<br>
							<br>										
							<span class="text-info">
								<strong>Start Date</strong>
								<br>
								<?php echo $view_model->start?>
							</span>
							<br>
							<br>
							<span class="text-info">
								<strong>End Date</strong>
								<br>
								<?php echo $view_model->finish?>
							</span>
							<br>
							<br>
							<span class="text-info">
								<strong>Time Left</strong>
								<p id="countdown"></p>
							</span>
						</div>
			</div>
		</div>
	</div>
	<br>

<div class="modal fade bd-example-modal-lg" id="modalBid" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle" style="font-size: 35px; color: #37A000;">Bid History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div><span class="bid-his-span">Bidders:</span><span id="historyBidderCount" class="bid-his-span-child"></span>
      	   <span class="bid-his-span">Bids:</span><span id="historyBidCount" class="bid-his-span-child"></span>
      </div>
      <hr>
          <table id="bidHistoryTable" style="margin: 5px; width: 650px;">
		      <tr>
				  <th class="bid-his-row">
					Bidder</th>
			   	  <th class="bid-his-row">Amount</th>
				  <th class="bid-his-row">Time</th>
		      </tr>
		  </table>
          <table id="bidHistoryItems" style="margin: 5px; width: 650px;">
		      
		  </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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
<?php
}
// view model is null - no auction found
else {
	echo "no auction";
}
?>
</body>
</html>
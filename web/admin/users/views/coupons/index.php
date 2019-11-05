<?php

?>
<!DOCTYPE html>
<html>

<head>
<script type="text/javascript">
	function saveCoupon() {
		alert("saved!");
	}
</script>
</head>


<style>
.card-columns {column-count: 5 !important;} 
.border-img {border-radius: 2%;} 

.card-div {
    border: 0px !important;
    padding: 4%;
}
.card-div:hover {
    border: 1px solid #EAFCE3 !important;
    background-color: #EAFCE3 !important;
    cursor: zoom-in;
    opacity: 0.6;
}

.divCol {
    text-align: justify;
    text-justify: inter-word;
}

.divModalColor {
    background-color: #F2FCEE !important;
}
</style>
<?php
// var_dump($view_model);
?>
<body>
	<div class="container" style="padding-top: 8%;">
		<div class="card-columns">
<?php
			foreach ($view_model as $coupon) {	
?>
				<div class="card card-div" data-toggle="modal" data-target="#imgModal" data-provider="<?php echo $coupon->partnerName?>" data-providerhash="<?php echo $coupon->partnerHash?>" data-profile="<?php echo 'partners-subdomain/assets/img/uploads/partners/default.png'?>" data-title="<?php echo $coupon->title?>" data-couponhash="<?php echo $coupon->hash?>" data-description="<?php echo $coupon->description?>" data-start="<?php echo $coupon->start_date?>" data-end="<?php echo $coupon->end_date?>" data-image="<?php echo 'partners-subdomain/assets/img/uploads/coupons/' . $coupon->photo_basenames[0] . ".png"?>">
					<img class="card-img-top border-img" src="<?php echo 'partners-subdomain/assets/img/uploads/coupons/' . $coupon->photo_basenames[0] . ".png"?>" >
				</div>
<?php
			}
?>			
		</div>
	</div>


	<div class="modal fade" id="imgModal" tabindex="-1" role="dialog"
		aria-labelledby="imgModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content divModalColor">
				<div class="modal-header">
					<h4 class="coupon-title comColor" id="imgModalLabel"></h4>
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<img id="couponPhoto" class="card-img-top border-img"
							src="">
						</div>
						<div class="col divCol">
							<img id="partnerProfilePicture" src=""
							style="width: 35px; border-radius: 60%;"> <strong>&nbsp;&nbsp;<span class="provide-name comColor"></span></strong>
							<br>
							<br>
							<span class="comColor"><strong>Description</strong><br><span class="coupon-description"></span></span>
								<br>
								<br>
							<span class="comColor"><strong>Start</strong><br><span class="coupon-start"></span></span>
								<br>
								<br>
							<span class="comColor"><strong>End</strong><br><span class="coupon-end"></span></span>
								<br>
								<br>
							<button class="btn-success" onclick="saveCoupon()">Save</button>
						</div>
					</div>
				</div>
			</div>
			</div>
	</div>

	<script type="text/javascript">
	$('#imgModal').on('show.bs.modal', function (event) {
		  var button          = $(event.relatedTarget)
		  var provider        = button.data('provider')
		  var providerHash    = button.data('providerhash')
		  var couponHash      = button.data('couponhash')
		  var title           = button.data('title')
		  var description     = button.data('description')
		  var start_date      = button.data('start')
		  var end_date        = button.data('end')		  
		  var coupon_photo    = button.data('image')
		  var profile_picture = button.data('profile')

		  var modal = $(this)
		  modal.find('.provide-name').html('<a href=/partners/' + providerHash + '>' + provider + '</a>')
		  modal.find('.coupon-title').html('<a href=/coupons/' + couponHash + '>' + title + '</a>')
		  modal.find('.coupon-description').text(description)
		  modal.find('.coupon-start').text(start_date)
		  modal.find('.coupon-end').text(end_date)
		  modal.find('#couponPhoto').attr('src', coupon_photo);
		  modal.find('#partnerProfilePicture').attr('src', profile_picture);
		})
	</script>
</body>

</html>
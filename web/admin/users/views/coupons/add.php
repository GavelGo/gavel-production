<?php 
// test
$_SESSION['partner_category_id'] = 1;
$_SESSION['provider_id'] = 1;
$_SESSION['category_name'] = 'Outdoor';
$_SESSION['category_hash'] = '576atiuyoudlhfj';
$_SESSION['partner_hash'] = 'temp5r6tyfgjhk';
$_SESSION['partner_name'] = 'Tarin Construction';
?>
<!DOCTYPE html>
<html>

<head>
<title>Add Coupon</title>
</head>
<style>
#html_btn {
	display: none;
}

.zoom {
    transition: transform .2s;
    width: 160px;
    height: 120px;
    margin: 0 auto;
    
}

.zoom:hover {
    position: absolute;
    z-index: 2;
    -ms-transform: scale(2.5); /* IE 9 */
    -webkit-transform: scale(2.5); /* Safari 3-8 */
    transform: scale(2.5); 
}

.btn-outline-success:hover{
    color: #fff !important;
    background-color: #37A000 !important;
    border-color: #285e8e !important; /*set the color you want here*/
}
</style>

<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input:radio[name="typeRadio"]').change(function(){
		    var couponType = $('input[name=typeRadio]:checked').val();
		    if (couponType === 'online') {
		    	$('#onlineCodeDiv').show();
		    	$("#code").prop('required',true);		
		    }
		    else {
		    	$('#onlineCodeDiv').hide();
		    	$("#code").prop('required',false);
		    }
		});
	});
</script>


	<div class="container" style="padding-top: 80px; ">
		<div class="main-content-container container-fluid bg-light" style="padding-left: 280px; ">
			<!-- Page Header -->
			<div class="page-header row no-gutters py-4">
				<div class="col-10 text-center text-sm-left comColor">
					<h4>Add a Coupon</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10">
					<div class="card card-small mb-4">
						<ul class="list-group list-group-flush">
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col">
										<form action="/coupons/add" enctype="multipart/form-data" method="POST">
											<input type="hidden" name="category_id" value="<?php echo $_SESSION['partner_category_id']?>">
											<input type="hidden" name="partner_id" value="<?php echo $_SESSION['provider_id']?>">
											<input type="hidden" name="category_name" value="<?php echo $_SESSION['category_name']?>">
											<input type="hidden" name="partner_hash" value="<?php echo $_SESSION['partner_hash']?>">
											<input type="hidden" name="partner_name" value="<?php echo $_SESSION['partner_name']?>">
											<input type="hidden" name="category_hash" value="<?php echo $_SESSION['category_hash']?>">
											<!-- submission type for Ratchet -->
											<input type="hidden" name="submission_type" value="partnerActivity" />
											<input type="hidden" name="content_type" value="coupon" />
											<div class="form-row" style="padding-left: 5px;">
												<div class="btn-group">
                                                   <label class="btn btn-outline-success" style="border-radius: 5px;"> 
		                                               <input type="radio" name="typeRadio" value="online" id="option1"> <i class="fas fa-desktop"></i> &nbsp;Online
	                                               </label> 
	                                               	   <span style="padding-left: 5px;"></span>
	                                               <label class="btn btn-outline-success" style="border-radius: 5px;"> 
		                                               <input type="radio" name="typeRadio" value="instore" id="option2"> <i class="fas fa-tags">&nbsp;  In Store </i>
                                                   </label> 
                                                </div>
											</div>
											<!-- hide until online code radio button pressed-->												
											<div class="form-row" id="onlineCodeDiv" style="display: none;">
													<div class="form-group col-md-10">
														<label for="online_code" class="labeling">Code</label>
														<input type="text" class="form-control" name="online_code" id="online_code">
													</div>
											</div>
											<div class="form-row" id="title">
												<div class="form-group col-md-10">
													<label for="title" class="labeling">Title</label>
													<input type="text" class="form-control" name="title" required="required">
												</div>
											</div>
											<div class="form-row" id="price">
												<div class="form-group col-md-10">
													<label for="price" class="labeling">Price</label>
													<input type="text" class="form-control" name="price" required="required">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="description">Description</label>
													<textarea class="form-control" rows="2" id="description" onkeyup="textCounter('remainingDescriptionCharacters', 'description', 255)" name="description" placeholder="Tell us more about the offer"></textarea><span id="remainingDescriptionCharacters"></span>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="restrictions">Restrictions</label>
													<textarea class="form-control" rows="2" id="restrictions" onkeyup="textCounter('remainingRestrictionCharacters', 'restrictions', 255)" name="restrictions" placeholder="Tell us more about the offer"></textarea><span id="remainingRestrictionCharacters"></span>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="expires">Start Date</label>
													<input type="date" class="form-control" id="start" name="start_date" placeholder="MM/DD/YYYY" required="required"></input>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="expires">End Date</label>
													<input type="date" class="form-control" id="end" name="end_date" placeholder="MM/DD/YYYY" required="required"></input>
												</div>
											</div>
											<br>
											<div class="form-row">
												<div class="form-group col-md-10" style="padding-left: 5px;">
													<button type="submit" class="btn btn-success" name="submit">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>GavelGo</title>
<link rel="icon" type="image/png" href="../../assets/img/gav.png"
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

<script type="text/javascript">
	function unsubscribe() {
		alert("unsubscribe test!");
	}
</script>
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

.listpadding{
    padding-top: 5px;
}
</style>
<body>
<?php
if (is_null($view_model)) {
	// redirect to login
	// todo - add http referer, so can return to profile page once logged in
	header("Location: /login");
	die();
}
else {
	if (!is_null($view_model->address_line_one)) {
		$full_address = $view_model->address_line_one . ", " . $view_model->address_line_two . ", " . $view_model->city . ", " . $view_model->state . ", " . $view_model->zipcode;
	}
	else {
		$full_address = "";
	}
}
?>
	<div class="container content" style="padding-top: 85px;">
		<div style="padding-left: 16px; width: 1095px;">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item"><a class="nav-link active" id="Contact-tab"
					data-toggle="tab" href="#Contact" role="tab" aria-controls="Contact"
					aria-selected="true">Contact</a></li>
				<li class="nav-item"><a class="nav-link" id="Notifications-tab"
					data-toggle="tab" href="#Notifications" role="tab"
					aria-controls="Notifications" aria-selected="false">Notifications</a></li>
				<li class="nav-item"><a class="nav-link" id="Subscriptions-tab"
					data-toggle="tab" href="#Subscriptions" role="tab"
					aria-controls="Subscriptions" aria-selected="false">Subscriptions</a></li>
			</ul>
		</div>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="Contact" role="tabpanel"
				aria-labelledby="Contact-tab">
				<!-- Profile Div Starts  -->
				<div class="container tabcontent">
					<div class="main-content-container container-fluid px-4 bg-light">
						<!-- Page Header -->
						<div class="page-header row no-gutters py-4">
							<div class="col-12 col-sm-4 text-center text-sm-left mb-0 comColor">
								<h4>Customer Profile</h4>
							</div>
						</div>
						<!-- End Page Header -->
						<!-- Default Light Table -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card card-small mb-4">
									<div class="card-header border-bottom bg-white">
										<h6 class="m-0 comColor">Customer Information Details</h6>
									</div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item p-3">
											<div class="row" style="padding-left: 15px; padding-right: 15px;">
												<div class="col">
													<form>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label for="cFirstName" class="labeling">First Name</label>
																<input type="text" class="form-control" id="cFirstName"
																	placeholder="First Name" value="<?php echo $view_model->first_name;?>">
															</div>
															<div class="form-group col-md-6">
																<label for="cLastName" class="labeling">Last Name</label>
																<input type="text" class="form-control" id="cLastName"
																	placeholder="Last Name" value="<?php echo $view_model->last_name;?>">
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label for="cEmailAddress" class="labeling">Email</label>
																<input type="email" class="form-control"
																	id="cEmailAddress" placeholder="Email"
																	value="<?php echo $view_model->email;?>">
															</div>
															<div class="form-group col-md-6">
																<label for="cPhone" class="labeling">Phone Number</label>
																<input type="text" class="form-control" id="cphone"
																	value="<?php echo $view_model->phone_number;?>">
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-12">
																<label for="cInputLocation" class="labeling">Location</label>
																<input type="text" class="form-control"
																	id="cInputLocation"
																	value="<?php echo $full_address;?>">
															</div>

														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label for="cPicture" class="labeling">Picture</label><br>
																<img class="img-circle"
																	src="../assets/img/profile-pic.png" alt="User Avatar"
																	width="70px" style="border-radius: 35px;"> 
																	<span style="padding-left: 15px;"></span>
																<button class="btn btn-outline-secondary new_Btn">Change Picture</button>
																<input id="html_btn" type='file' /><br>
															</div>
														</div>
														<br>
														<div class="form-row">
															<div class="form-group col-md-12"
																style="padding-left: 0px;">
																<button type="submit" class="btn btn-success"
																	onclick="myAlert('account')">Update Customer Profile</button>
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
				<!-- Profile Div Ends  -->
			</div>
			<div class="tab-pane fade" id="Notifications" role="tabpanel"
				aria-labelledby="Notifications-tab">
				<!-- Notification Div Starts  -->

				<div class="container tabcontent">

					<div class="main-content-container container-fluid px-4 bg-light">
						<!-- Page Header -->
						<div class="page-header row no-gutters py-4">
							<div class="col-12 col-sm-4 text-center text-sm-left mb-0 comColor">
								<h4>Customer Profile</h4>
							</div>
						</div>
						<!-- End Page Header -->
						<!-- Default Light Table -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card card-small mb-4">
									<div class="card-header border-bottom bg-white">
										<h6 class="m-0 comColor">Notification Details</h6>
									</div>
									<ul class="list-group list-group-flush"
										style="padding-left: 20px;">
										<li class="list-group-item p-3">
											<div class="row">
												<div class="col">
													<form>
														<div class="card-header border-bottom bg-white">
															<h6 class="m-0 comColor">Providers</h6>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check1"> <label class="form-check-label"
																for="check1"> Subscriptions </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Trending </label>
														</div>

														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check1"> <label class="form-check-label"
																for="check1"> Suggested </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Direct Message </label>
														</div>
														<div class="card-header border-bottom bg-white">
															<h6 class="m-0 comColor">Coupons</h6>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check1"> <label class="form-check-label"
																for="check1"> Saved </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Suggested </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Top </label>
														</div>
														<br>
														<div class="form-row">
															<div class="form-group col-md-12"
																style="padding-left: 0px;">
																<button type="submit" class="btn btn-success"
																	onclick="myAlert('account')">Update Notifications</button>
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
				<!-- Notification Div Ends  -->
			</div>
			<div class="tab-pane fade" id="Subscriptions" role="tabpanel"
				aria-labelledby="Subscriptions-tab">
				<!-- Subscriptions Div Starts  -->

				<div class="container tabcontent">

					<div class="main-content-container container-fluid px-4 bg-light">
						<!-- Page Header -->
						<div class="page-header row no-gutters py-4">
							<div class="col-12 col-sm-4 text-center text-sm-left mb-0 comColor">
								<h4>Customer Profile</h4>
							</div>
						</div>
						<!-- End Page Header -->
						<!-- Default Light Table -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card card-small mb-4">
									<div class="card-header border-bottom bg-white">
										<h6 class="m-0 comColor">Subscription Details</h6>
									</div>
									<ul class="list-group list-group-flush"
										style="padding-left: 20px;">
										<li class="list-group-item p-3">
											<div class="row">
												<div class="col">
													<form>
														<div class=" card-header bg-white">
															<h6 class="m-0 comColor">Providers</h6>
														</div>
														<div class="row">
<?
														foreach ($view_model->provider_subscriptions as $provider => $value) {
?>
															<div class="col-sm-3">
																<div class="card">
																	<div class="card-body text-center">
																		<h5 class="card-title"><img src="../assets/providers/1.png"></h5>
																		<p class="card-text"><?php echo $value?></p>
																		<a href="#" class="btn btn-success btn-sm btn-block" onclick="unsubscribe()">Subscribed</a>
																	</div>
																</div>
															</div>
<?php
														}
?>
														</div>
														<div class="card-header border-bottom bg-white">
															<h6 class="m-0 comColor">Saved Coupons</h6>
														</div>
														<div class="row">
															<div class="col-sm-3">
																<div class="card">
																	<div class="card-body text-center">
																		<img src="../assets/providers/coupon.png" class="zoom">
																	</div>
																</div>
															</div>
															<div class="col-sm-3">
																<div class="card">
																	<div class="card-body text-center">
																		<img src="../assets/providers/coupon.png" class="zoom">
																	</div>
																</div>
															</div>
															<div class="col-sm-3">
																<div class="card">
																	<div class="card-body text-center">
																		<img src="../assets/providers/coupon.png" class="zoom">
																	</div>
																</div>
															</div>
															<div class="col-sm-3">
																<div class="card">
																	<div class="card-body text-center">
																		<img src="../assets/providers/coupon.png" class="zoom">
																	</div>
																</div>
															</div>
														</div>
														<div class="card-header border-bottom bg-white">
															<h6 class="m-0 comColor">Categories</h6>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check1"> <label class="form-check-label"
																for="check1"> Yard Work </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Catering </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Automotive </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Cleaning Products </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Haircare </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Pet Supplies </label>
														</div>
														<div class="form-check listpadding">
															<input class="form-check-input" type="checkbox" value=""
																id="check2"> <label class="form-check-label"
																for="check2"> Outdoors </label>
														</div>
														<br>
														<div class="form-row">
															<div class="form-group col-md-12"
																style="padding-left: 0px;">
																<button type="submit" class="btn btn-success"
																	onclick="myAlert('account')">Update Notifications</button>
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
				<!-- Subscriptions Div Ends  -->
			</div>
		</div>

	</div>
	<script type="text/javascript">
	$('.new_Btn').bind("click" , function () {
	    $('#html_btn').click();
	});
	</script>
</body>

</html>
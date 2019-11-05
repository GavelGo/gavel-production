<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Add Coupon</title>
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
	<div class="container" style="padding-top: 80px; ">
				<!-- Profile Div Starts  -->

					<div class="main-content-container container-fluid bg-light" style="padding-left: 280px; ">
						<!-- Page Header -->
						<div class="page-header row no-gutters py-4">
							<div class="col-10 text-center text-sm-left comColor">
								<h4>Coupon</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10">
								<div class="card card-small mb-4">
									<div class="card-header border-bottom bg-white">
										<h6 class="m-0 comColor">Submit a coupon</h6>
									</div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item p-3">
											<div class="row">
												<div class="col">
													<form>
														<div class="form-row">
															<div class="form-group col-md-10">
																<label for="cFirstName" class="labeling">Store Website</label>
																<input type="text" class="form-control" id="store">
															</div>
														</div>
													<div class="form-row" style="padding-left: 5px;">
														<div class="btn-group" data-toggle="buttons">
                                                           <label class="btn btn-outline-success" style="border-radius: 5px;"> 
                                                           <input type="radio" name="options" id="option1"	autocomplete="off" checked> <i class="fas fa-desktop"></i> &nbsp;Online Code
                                                           </label> <span style="padding-left: 5px;"></span>
                                                           <label class="btn btn-outline-success" style="border-radius: 5px;"> 
                                                           <input type="radio" name="options" id="option2"  autocomplete="off"> <i class="fas fa-tags">&nbsp;  In-Store Coupon </i>
                                                           </label> 
                                                        </div>
													</div>
													<div class="form-row">
															<div class="form-group col-md-10">
																<label for="cCode" class="labeling">Code</label>
																<input type="text" class="form-control"
																	id="cCode"
																	placeholder="Code">
															</div>

													</div>
													<div class="form-row">
														<div class="form-group col-md-10">
															<label for="desc">Discount Description</label>
															<textarea class="form-control" rows="2" id="desc" placeholder="Tell us more about the offer"></textarea>
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-10">
															<label for="expires">Expiration Date (optional)</label>
															<input type="date" class="form-control" id="expires" placeholder="MM/DD/YYYY"></input>
														</div>
													</div>
													<br>
													<div class="form-row">
														<div class="form-group col-md-10"
															style="padding-left: 5px;">
															<button type="submit" class="btn btn-success"
																onclick="myAlert('account')">Submit Coupon Profile</button>
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
				<!-- Profile Div Ends  -->
	</div>		


	<script type="text/javascript">
	$('.new_Btn').bind("click" , function () {
	    $('#html_btn').click();
	});
	</script>
</body>

</html>
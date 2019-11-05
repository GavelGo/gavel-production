<?php 
// test
$_SESSION['partner_category_id'] = 1;
$_SESSION['provider_id'] = 1;
?>
<!DOCTYPE html>
<html>

<head>
<title>Add Auction</title>
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
	<div class="container" style="padding-top: 80px; ">
		<div class="main-content-container container-fluid bg-light" style="padding-left: 280px; ">
			<!-- Page Header -->
			<div class="page-header row no-gutters py-4">
				<div class="col-10 text-center text-sm-left comColor">
					<h4>Add an Auction</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10">
					<div class="card card-small mb-4">
						<ul class="list-group list-group-flush">
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col">
										<form action="/auctions/add" enctype="multipart/form-data" method="POST">
											<input type="hidden" name="auction_category_id" value="<?php echo $_SESSION['partner_category_id']?>">
											<input type="hidden" name="auction_partner_id" value="<?php echo $_SESSION['provider_id']?>">	
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="auction_title" class="labeling">Title</label>
													<input type="text" class="form-control" name="auction_title" required="required">
												</div>
											</div>											
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="auction_description">Description</label>
													<textarea class="form-control" rows="2" id="coupon_description" name="auction_description" placeholder="Tell us more"></textarea>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="auction_reserve_price" class="labeling">Reserve/Starting Price</label>
													<input type="text" class="form-control" name="auction_reserve_price" cols="5" placeholder="$" required="required">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="auction_minimum_increment" class="labeling">Minimum Bid Increment</label>
													<input type="text" class="form-control" name="auction_minimum_increment" cols="5" placeholder="$" required="required">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="auction_start">Start Date</label>
													<input type="date" class="form-control" id="auction_start" name="auction_start" placeholder="MM/DD/YYYY" required="required"></input>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-10">
													<label for="auction_finish">End Date</label>
													<input type="date" class="form-control" id="auction_finish" name="auction_finish" placeholder="MM/DD/YYYY" required="required"></input>
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
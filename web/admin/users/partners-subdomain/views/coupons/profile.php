<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Coupon Profile</title>
</head>
<body>
<br />
<?php
Messages::display();

if(!is_null($request_data) && $request_data->id !== 0){
?>
	<h2><b>Title: </b><?php echo $request_data->title;?></h2>
	<p><b>Description: </b><?php echo $request_data->description;?></p>
	<p><b>Start: </b><?php echo date('F d, Y', strtotime($request_data->start_date));?></p>
	<p><b>End: </b><?php echo date('F d, Y', strtotime($request_data->end_date));?></p>
	<p><b>Restrictions: </b><?php echo $request_data->restrictions;?></p>
	<p><b>Photo: </b></p>
<?php
# in case photo was deleted or moved in filesystem, dispaly default photo: 
if(file_exists("assets/img/uploads/coupons/" . $request_data->photo)){
?>
	<img src="../../assets/img/uploads/coupons/<?php echo $request_data->photo;?>" alt="coupon picture" style="width:200px;height:200px;">
<?php
}
else {
?>
	<img src="../../assets/img/uploads/coupons/default.png" alt="coupon default picture" style="width:200px;height:200px;">
<?php
}
?>
	<br /><br />
	<form action="" method="POST" id="deleteCoupon">
		<input type="submit" name="delete_coupon" value="Delete Coupon">
	</form>
<?php
}
else {
	echo "<br />Nothing to see here...";
}
?>
</body>
</html>
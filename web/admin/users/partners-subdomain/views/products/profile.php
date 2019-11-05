<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Profile</title>
</head>
<body>
<h2><b>Title: </b><?php echo $request_data->title;?></h2>
<p><b>Description: </b><?php echo $request_data->description;?></p>
<p><b>Restrictions: </b><?php echo $request_data->restrictions;?></p>
<p><b>Photos: </b></p>
<?php
if(!is_null($request_data->photo)){
?>
	<img src="../assets/img/uploads/auctions/<?php echo $request_data->photo?>.png" alt="coupon picture" style="width:200px;height:200px;">
<?php
}
else {
?>
	<img src="../assets/img/uploads/auctions/default.png" alt="coupon default picture" style="width:200px;height:200px;">
<?php
}
?>
<button onclick="deleteProduct()">Delete</button>
</body>
</html>
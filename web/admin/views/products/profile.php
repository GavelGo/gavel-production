<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Profile</title>
</head>
<body>
<br />
<h3><a href="/profile">Back to Your Profile</a></h3>
<?php
?>
<h2><b>Title: </b><?php echo $view_model->title;?></h2>
<p><b>Description: </b><?php echo $view_model->description;?></p>
<p><b>Restrictions: </b><?php echo $view_model->restrictions;?></p>
<p><b>Photos: </b></p>
<?php
if(!is_null($view_model->photo)){
?>
	<img src="../assets/img/uploads/auctions/<?php echo $view_model->photo?>.png" alt="coupon picture" style="width:200px;height:200px;">
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
<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>LISTINGS</title>
</head>
<body>
<?php
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['partner_name'])){
	echo "<h1>YOUR LISTINGS</h1>";
	echo "<h2>Products</h2>";
	foreach ($request_data->products as &$prod) {
		 echo "<br /><b>" . $prod['product_name'] . "</b><br />";
		 echo $prod['product_cost'] . "<br />";
	}

	echo "<h2><br />Coupons</h2>";
	foreach ($request_data->coupons as &$cou) {
		$url_name = implode("-", explode(" ", strtolower($cou['coupon_title'])));
		?>
		<a href="<?php echo ROOT_URL . 'coupons/' . urlencode($url_name); ?>"><?php echo $cou['coupon_title']; ?></a>
		<br />
		<?php
		 echo $cou['coupon_description'] . "<br />";
		 echo "<hr>";
	}
}
else {
	echo "Log in to see your listings";
}
?>
</body>
</html>
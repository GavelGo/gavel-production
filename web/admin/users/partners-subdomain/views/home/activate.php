<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Account Activation</title>
</head>
<body>
<h1>ACTIVATE</h1>
<?php
if($request_data === 1){
	echo "<h2>Your Account has been activated! You can now Log In.</h2>";
	echo '<h2><a href="' . ROOT_URL . '">Home</a></h2>';
}
?>
</body>
</html>
<?php
?>
<!DOCTYPE html>
<head>
	<title>Gavelgo | Users</title>
</head>
<body>
<h1>Explore User Content</h1>
<p>This is mostly a useless page, just here for breadcrumb backlinking</p>
<?php

# only display forward link to user profile if user logged in: 
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['user_username'])){
	?>
	<a href="<?php echo CUST_ROOT_URL . 'users/personiusd';?>">Your Profile ></a>
	<?php
}
else {
?>
	<a href="<?php echo CUST_ROOT_URL . 'login';?>">Login</a>
<?php
}
?>
</body>
</html>

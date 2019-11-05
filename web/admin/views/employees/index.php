<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Employees</title>
</head>
<body>
<?php
Messages::display();
if(Authentication::has_permission($_SESSION['admin_id'], 3)){
?>
	<h1>EMPLOYEES</h1>
	<h2><a href="<?php echo ROOT_URL . 'employees/hours'?>">Hours</a></h2>
	<br /><br />
	<?php
	foreach ($view_model as $key => $employee) {
		$url_name = implode("-", explode(" ", $employee->full_name));

		echo $key . ": ";
		print_r(get_object_vars($employee));
		echo '<br /><a href="/employees/' . strtolower($url_name) . '">Profile</a>';	
		echo "<br /><br />";
	}
}
else {
?>
	<h2>Access Restricted</h2>
<?php
}
?>
</body>
</html>
<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
</head>
<body>
<h1>PROFILE</h1>
<?php
var_dump($view_model);
?>
<br />
<h2>Log Hours</h2>
<form action="" method="POST" id="logHoursForm">
	<label for="start_time">Start</label>
	<br />
	<input type="time" name="start_time">
	<br />
	<label for="end_time">End</label>
	<br />
	<input type="time" name="end_time">
	<br />
	<label for="date_time">DateTime</label>
	<br />
	<input type="datetime" name="date_time">
	<br /><br />
	<input type="submit" name="submit" value="Log">
</form>
</body>
</html>
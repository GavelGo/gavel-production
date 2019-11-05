<?php
/**
* 
* @todo ajax call to update feed 
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Public Profile</title>
	

<style type="text/css">
	body {
			/* background-image: url(<?php #echo "../../assets/img/uploads/providers/" . $request_data->photo_basename?>);
			background-repeat: no-repeat;
			background-size: cover; */
	}
</style>
</head>
<body>
	<h1>PROFILE</h1>
	<h3><a href="/edit-profile">Edit</a></h3>
<?php
Messages::display();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['partner_id'])){
	foreach ($request_data as $key => $value) {
		if(is_array($value)){
			// not empty
			if(!empty($value)){
				// array contains an object(coupon)
				if(is_object($value[0])){
					print_r(get_object_vars($value[0]));
				}
				// not an object
				else {
					print_r($value);
				}
			}
			// empty array
			else {
				echo "None";
			}
		}
		// not an array
		else {
			echo $value;
		}
	}
?>
	<h1><br />FEED</h1>
<?php
	$posts = $request_data->get_posts();
	foreach ($posts as $key => $value) {
		echo "<p><b>" . $value["post"] . "</b></p>";
		echo "<p>" . date('F d, Y', strtotime($value["time_submitted"])) . "</p><br />";
	}
}
// not logged in
else {
	Messages::set_message('you must log in to view this page', 'error');
}
?>
</body>
</html>
<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Auctions</title>
</head>
<body>
<h1>My auctions</h1>
<?php
Messages::display();
var_dump($request_data);
if(!is_null($request_data)){
	foreach ($request_data as $key => $auction) {
		// ...
	}
	echo "<br />TODO: print out auction info";
}
else {
	// ...
}
?>
</body>
</html>
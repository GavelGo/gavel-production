<?php
session_start();
ini_set('display_errors', 1);

require("config.php");

require("classes/Messages.php");
require("classes/Cookie.php");
require("classes/Bootstrap.php");
require("classes/Controller.php");
require("classes/Model.php");
require("classes/SessionManager.php");
// require("classes/Auth.php");
require("classes/Sanitation.php");

require("controllers/home.php");
require("users/controllers/categories.php");
require("users/controllers/users.php");
require("controllers/employees.php");
require("users/partners-subdomain/controllers/partners.php");
require("users/partners-subdomain/controllers/auctions.php");
require("users/partners-subdomain/controllers/coupons.php");

require("users/models/category.php");
require("models/employee.php");
require("users/models/user.php");
require("users/partners-subdomain/models/partner.php");
require("models/bid.php");
require("users/partners-subdomain/models/coupon.php");
require("models/home.php");

# request
$bootstrap = new Bootstrap(Sanitation::clean_data($_GET));
$controller = $bootstrap->createController();

if($controller){
	$controller->execute_action();
}
else {
	header("Location: notfound");
}

?>


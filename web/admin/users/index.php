<?php
use PartnerDomain\Bootstrap;
use PartnerDomain\Sanitation;

// autoload
require_once 'vendor/autoload.php';

// CLASSES
require_once "partners-subdomain/config.php";
require_once "partners-subdomain/classes/Bootstrap.php";
require_once "partners-subdomain/classes/Controller.php";
require_once "partners-subdomain/classes/Model.php";
require_once "partners-subdomain/classes/Messages.php";
require_once "partners-subdomain/classes/Utilities.php";
require_once "partners-subdomain/classes/SessionManager.php";
require_once "partners-subdomain/classes/Sanitation.php";
require_once "partners-subdomain/classes/Websocket.php";
require_once "classes/Authentication.php";

// CONTROLLERS
require_once("controllers/home.php");
require_once("partners-subdomain/controllers/categories.php");
require_once("partners-subdomain/controllers/partners.php");
require_once("partners-subdomain/controllers/users.php");
require_once("partners-subdomain/controllers/auctions.php");
require_once("partners-subdomain/controllers/coupons.php");
require_once("partners-subdomain/controllers/search.php");

// MODELS
require_once "partners-subdomain/models/partner.php";
require_once "partners-subdomain/models/category.php";
require_once "partners-subdomain/models/user.php";
require_once "models/home.php";
require_once "partners-subdomain/models/auction.php";
require_once "partners-subdomain/models/coupon.php";
require_once "partners-subdomain/models/search.php";
require_once "partners-subdomain/models/Notification.php";

// request
$bootstrap  = new Bootstrap(Sanitation::clean_data($_GET));
$controller = $bootstrap->createController();

if($controller){
	$controller->execute_action();
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
</body>
</html>
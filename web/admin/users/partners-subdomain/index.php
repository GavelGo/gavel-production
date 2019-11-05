<?php
// ini_set('display_errors', 1);
use PartnerDomain\Bootstrap;
use PartnerDomain\Sanitation;

// autoload
require 'vendor/autoload.php';

// CLASSES
require "partners-subdomain/config.php";
require "partners-subdomain/classes/Bootstrap.php";
require "partners-subdomain/classes/Controller.php";
require "partners-subdomain/classes/Model.php";
require "partners-subdomain/classes/Messages.php";
require "partners-subdomain/classes/Utilities.php";
require "partners-subdomain/classes/SessionManager.php";
require "partners-subdomain/classes/Sanitation.php";

// CONTROLLERS
require("partners-subdomain/controllers/home.php");
require("controllers/categories.php");
require("partners-subdomain/controllers/partners.php");
require("controllers/users.php");
require("partners-subdomain/controllers/auctions.php");
require("partners-subdomain/controllers/coupons.php");
require("controllers/search.php");

// MODELS
require "partners-subdomain/models/home.php";
require "partners-subdomain/models/partner.php";
require "models/category.php";
require "models/user.php";
require "partners-subdomain/models/auction.php";
require "partners-subdomain/models/coupon.php";
require "models/search.php";
require "partners-subdomain/models/Notification.php";

# request
$bootstrap = new Bootstrap(Sanitation::clean_data($_GET));
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
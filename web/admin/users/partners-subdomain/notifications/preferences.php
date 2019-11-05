<?php
// define DB params
define("DB_HOST", "localhost");
define("DB_USER", "customer");
define("DB_PASS", "k9TxYBg2pIRoweYO");
define("DB_NAME", "gavelgo");
require $_SERVER['DOCUMENT_ROOT'] . "/partners-subdomain/classes/Model.php";
require $_SERVER['DOCUMENT_ROOT'] . "/partners-subdomain/classes/Notification.php";

$userId = 15;
$preferences = Notification::getUserNotificationPreferences($userId);
$subscriptions = Notification::getUserNotificationSubscriptions($userId);

var_dump($preferences);
var_dump($subscriptions);
?>
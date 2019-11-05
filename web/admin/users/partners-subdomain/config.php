<?php
// define DB params
define("DB_HOST", "localhost");
define("DB_USER", "customer");
define("DB_PASS", "k9TxYBg2pIRoweYO");
define("DB_NAME", "gavelgo");

// URLs
define("ROOT_PATH", "/");
define("ROOT_URL", "http://partners.gavelgo.com/");
define("CUST_ROOT_URL", "http://gavelgo.com/");

// files
// maybe just get from php.ini
define("PHP_LOG", "/Applications/MAMP/logs/php_error.log");
define("MYSQL_LOG", "/Applications/MAMP/logs/mysql_error.log");
define("APACHE_LOG", "/Applications/MAMP/logs/apache_error.log");

// directory paths
define("COUPON_IMG_DIR", "partners-subdomain/assets/img/uploads/coupons/");
define("AUCTION_IMG_DIR", "partners-subdomain/assets/img/uploads/auctions/");
define("PARTNER_IMG_DIR", "partners-subdomain/assets/img/uploads/partners/");

// file extensions
define("IMG_EXTENSION", ".png");

// pubsub
define("WEBSOCKET_ENDPOINT", "ws://localhost:8080");

// html elements
define("NEW_NOTIFICATION_ELEMENT", "notificationItems");
define("DIRECT_MESSAGE_ELEMENT", "direct_message_element");
?>
<?php

// READY TO MOVE TO MAIN.PHP

require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/classes/Notification.php');

// test
$_SESSION['user_id'] = 123;
$providerId = 111;
$couponSubscriptions   = array('cpn-43w5erytughkjl', 'cpn-2');
$auctionSubscriptions  = array('act-1');
$providerSubscriptions = array('prt-1');

// in config
define("NEW_NOTIFICATION_ELEMENT", "notif-bar-0");
define("WEBSOCKET_ENDPOINT", "ws://localhost:8080");

// get subscription settings
$notificationPreferences = Notification::getUserNotificationPreferences($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script src="https://rawgit.com/cboden/fcae978cfc016d506639c5241f94e772/raw/e974ce895df527c83b8e010124a034cfcf6c9f4b/autobahn.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="/partners-subdomain/assets/js/pubsub.js"></script>
<script>
    // prevent refresh on form submit so no reconnection to pubsub server
    $(document).ready(function() {
        $('#messageForm').submit(function () {
            // clear form fields
            $('input[name=message').val('');
            return false;
        });
    });

    connectUser('<?php echo WEBSOCKET_ENDPOINT; ?>', 
                "<?php echo $_SESSION['user_id'];?>", 
                <?php echo json_encode($couponSubscriptions); ?>, 
                <?php echo json_encode($auctionSubscriptions); ?>,
                <?php echo json_encode($providerSubscriptions); ?>,
                "<?php echo NEW_NOTIFICATION_ELEMENT; ?>");

</script>
<h1>user <?php echo $_SESSION['user_id']; ?></h1>
<p>Notification: </p>
<p id="<?php echo NEW_NOTIFICATION_ELEMENT?>"></p>
</body>
</html>
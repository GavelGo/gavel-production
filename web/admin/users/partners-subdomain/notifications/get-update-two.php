<?php

// READY TO BE MOVED OR DELETED


$_SESSION['user_id'] = $456;
$providerId = 111;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>user <?php echo $_SESSION['user_id']; ?></h1>

<script src="https://rawgit.com/cboden/fcae978cfc016d506639c5241f94e772/raw/e974ce895df527c83b8e010124a034cfcf6c9f4b/autobahn.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="/partners-subdomain/assets/js/pubsub.js"></script>
<script>
    var conn = new ab.Session('ws://localhost:8080',
        function() {
            console.log(conn);
            var userId = "<?php echo $_SESSION['user_id'] ?>"

            conn.subscribe('2', function(category, data) {
                console.log(data);
                // var parsed = JSON.parse(data);
                // document.getElementById("demo").innerHTML = parsed;

                // console.log('New coupon published to category id "' + category + '" : ' + data.title);
            });

            conn.subscribe(userId, function(reason, message) {
                // verify the user's session id and subscription id match to avoid spoofing subscriptions
                if (<?php echo $_SESSION['user_id']; ?> == arguments[0]) {
                    document.getElementById(userId).innerHTML = "Message from provider 111: " + JSON.parse(message).message;
                }
                else {
                    console.error("You are not authorized to receive this message.");
                }
            });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
</script>
</body>
<p id="<?php echo $_SESSION['user_id']; ?>">I am user <?php echo $_SESSION['user_id']; ?>!</p>
</html>
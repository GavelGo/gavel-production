# potential pubsub functionality 


## preferences
### config.php

```
// defaults
define("DEFAULT_USER_NOTIFICATION_PREFERENCES", array(
    "coupon"         => 1,
    "auction"        => 1,
    "partner"        => 1,
    "general"        => 1,
    "expiration"     => 1,
    "administrative" => 1,
    "message"        => 1
));
```

### Notification model
```
/**
	*
	*/
	public static function setDefaultUserNotificationPreferences($userId = 0) {
		if ($userId !== 0) {
			if($stmt = Model::give_dbh()->prepare("INSERT INTO user_notification_preferences (user_id, notification_type, should_receive) 
				VALUES (?,?,?)
				ON DUPLICATE KEY UPDATE notification_type=VALUES(notification_type), should_receive=VALUES(should_receive)")){
				foreach (DEFAULT_USER_NOTIFICATION_PREFERENCES as $key => $value) {
					$stmt->bind_param('', $userId, $key, $value);
					$stmt->execute();
				}
				$stmt->close();
			}
			else {
				// log
			}
		}
		else {
			// log
		}
	}

	/**
	* @todo return type and value
	*/
	public static function updateUserNotificationPreferences($userId = 0, $preferences) {
		if($stmt = Model::give_dbh()->prepare("UPDATE user_notification_preferences 
			SET should_receive=?
			WHERE type=?")){
			foreach ($preferences as $notificationType => $preference) {
				$stmt->bind_param('', $preference, $notificationType);
				$stmt->execute();
			}
		}
		else {
			// log
		}
		return 0;
	}

	/**
	*
	*/
	public static function getUserNotificationPreferences($userId = 0) {
		$preferences = null;

		$dbh = Model::give_dbh();
		if($stmt = $dbh->prepare("SELECT n.type, p.should_receive 
			FROM notification_type n
			INNER JOIN user_notification_preference p
			ON n.id=p.notification_type
			AND p.user_id=?")){
			$stmt->bind_param('i', $userId);
			if(!$stmt->execute()){
				// log
			}
			else {
				$preferences = array();
				$result = $stmt->get_result();
				while($row = $result->fetch_assoc()){
					$preferences[$row['type']] = $row['should_receive'];
				}
			}
		}
		else {
			// log
		}

		return $preferences;
	}
```

### main.php
```
if ($_SESSION['logged_in'] === 1) {
    $subscriptions = Notification::getUserNotificationSubscriptions($_SESSION['user_id']);
}
```

### db tables

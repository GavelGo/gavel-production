<?php
namespace PartnerDomain;

/**
* 
*/
class Notification extends Model implements \JsonSerializable {
	// int
	public $id            = null;
	// string
	public $type          = null;
	// string
	public $body          = null;
	// string
	public $created       = null;
	// string
	public $partner_hash  = null;
	// string
	public $partner_name  = null; 
	// string
	public $category_hash = null;
	// string
	public $category_name = null;
	// int, 1 if viewed/read
	public $is_read       = 0;
	// string
	public $hash          = "";
	// int
	public $user_id       = null;
	// string
	public $link          = null;

	public function __construct($data = array()){
		parent::__construct('notification', 'php');

		$this->id = (isset($data['id']) && !empty($data['id'])) ? (int)$data['id'] : $this->id;

		$this->type = (isset($data['type']) && !empty($data['type'])) ? $data['type'] : $this->type;

		$this->body = (isset($data['body']) && !empty($data['body'])) ? (string)$data['body'] : $this->body;

		$this->created = (isset($data['created']) && !empty($data['created'])) ? $data['created'] : $this->created;

		$this->partner_hash = (isset($data['partner_hash']) && !empty($data['partner_hash'])) ? (string)$data['partner_hash'] : $this->partner_hash;

		$this->partner_name = (isset($data['partner_name']) && !empty($data['partner_name'])) ? (string)$data['partner_name'] : $this->partner_name;

		$this->category_hash = (isset($data['category_hash']) && !empty($data['category_hash'])) ? (string)$data['category_hash'] : $this->category_hash;

		$this->category_name = (isset($data['category_name']) && !empty($data['category_name'])) ? (string)$data['category_name'] : $this->category_name;

		$this->is_read = (isset($data['is_read']) && !empty($data['is_read'])) ? (int)$data['is_read'] : $this->is_read;


		$this->hash = (isset($data['hash']) && !empty($data['hash'])) ? (string)$data['hash'] : $this->hash;

		$this->user_id = (isset($data['user_id']) && !empty($data['user_id'])) ? (int)$data['user_id'] : $this->user_id;

		switch ($this->type) {
			case 'coupon':
				$this->link = "/coupons/";
				break;

			case 'auction':
				$this->link = "/auctions/";
				break;
			
			default:
				break;
		}
		$this->link .= $this->hash;

	}

	/**
	*
	*/
	public function jsonSerialize() {
        return 
        [
            'id'            => $this->id,
            'type'          => $this->type,
            'body'          => $this->body,
            'created'       => $this->created,
            'partner_hash'  => $this->partner_hash,
            'partner_name'  => $this->partner_name,
            'category_hash' => $this->category_hash,
            'category_name' => $this->category_name,
            'is_read'       => $this->is_read,
            'hash'          => $this->hash,
            'user_id'       => $this->user_id,           
            'link'          => $this->link
        ];
    }

    /**
    *
    */
    public static function sendNotification ($message) {	
		$socket = Websocket::connect_publisher();
	    $socket->send(json_encode($message));
    }

	/**
	* 
	*/
	public static function saveUserNotification ($type, $partnerHash, $categoryHash, $body, $hash) {
		$notification = null;
		$notificationId = null;
		$coupon_hash = null;
		$auction_hash = null;

		$created = Utilities::getCurrentTimestamp();

		$query = "INSERT INTO notification(type, partner_hash, category_hash, body, created, coupon_hash, auction_hash) VALUES(?,?,?,?,?,?,?)";

		switch ($type) {
			case 'coupon':
				$coupon_hash = $hash;
				break;

			case 'auction':
				$auction_hash = $hash;
				break;

			default:
				break;
		}

		$results = self::affectRowsPrepared($query, 'sssssss', $type, $partnerHash, $categoryHash, $body, $created, $coupon_hash, $auction_hash);
		if ($results['affected_rows'] === 1) {
			$notification = new self(array(
				'id'            => $results['insert_id'],
				'type'          => $type,
				'body'          => $body,
				'created'       => $created,
				'partner_hash'  => $partnerHash,
				'category_hash' => $categoryHash,
				'hash'          => $hash
			));
		}

		return $notification;
	}

	/**
	*
	*/
	public static function saveUserNotificationStatus($notification_id, $user_id, $is_read = 0) {
		$insertStatus = -1;
		$query = "INSERT INTO user_notification_status(notification_id, user_id, is_read) VALUES(?,?,?)";
		$results = self::affectRowsPrepared($query, 'iii', $notification_id, $user_id, $is_read);
		return $results['affected_rows'];
	}

	/**
	*
	*/
	public static function getNotifications($userId, $onlyUnread = false, $limit = 0, $orderBy = "is_read ASC, created DESC") {
		$notifications = array();

		$query = "SELECT n.id, n.type, n.body, u.user_id, p.name as partner_name, p.hash AS partner_hash, c.category_hash, c.category_name, CASE WHEN n.coupon_hash IS NULL 
		                                         THEN n.auction_hash
		                                         ELSE n.coupon_hash
		                                         END AS hash, u.is_read, n.created 
		          FROM notification n
		          INNER JOIN partner p
		          ON n.partner_hash=p.hash
		          INNER JOIN category c
		          ON n.category_hash=c.category_hash
		          INNER JOIN user_notification_status u
		          ON u.notification_id=n.id
		          AND u.user_id=?
		          AND created<NOW()";

      	if ($onlyUnread) {
      		$query .= " AND u.is_read=0";
      	}
		
		// sort by creation time and read/unread status
		$query .= " ORDER BY " . $orderBy;

		// only want a few, e.g. for small notifications bar
		if ($limit !== 0) {
			$query .= " LIMIT " . $limit;
		}
		$results = self::selectPrepared($query, 'i', $userId);
		
		if (!is_null($results)) {
			foreach ($results as $row) {
				$notification = new self($row);
				$notifications[] = $notification;
			}
		}
		
		return $notifications;
	}

	/**
	*
	*/
	public static function getUnreadNotificationsCount($userId = 0){
		$unreadNotificationsCount = 0;
		$query = "SELECT COUNT(*)
		          FROM user_notification_status u 
		          INNER JOIN notification n
		          ON u.notification_id=n.id
		          AND u.user_id=?		         
		          AND u.is_read=0
		          AND n.created<NOW()";

		$dbh = Model::give_dbh();
		if($stmt = $dbh->prepare($query)){
			$stmt->bind_param('i', $userId);
			if(!$stmt->execute()){
				// log
			}
			else {
				$result = $stmt->get_result();
				$unreadNotificationsCount = $result->fetch_row()[0];
			}
		}
		else {
			// log
		}

		return $unreadNotificationsCount;
	}

	/**
	*
	*/
	public static function getUserNotificationSubscriptions($userId){
		$subscriptions = array(
			'coupons'  => array(),
			'auctions' => array(),
			'partners' => array()
 		);
		
		$couponQuery  = "SELECT c.hash
					  	 FROM saved_coupon s
						 INNER JOIN coupon c
						 ON s.user_id=?
						 AND s.coupon_id=c.id";
		$auctionQuery = "SELECT a.hash
		                 FROM saved_auction s
		                 INNER JOIN partner_auction a
		                 ON s.user_id=?
		                 AND s.auction_id=a.id";
        $partnerQuery = "SELECT p.hash
		                 FROM partner p
		                 INNER JOIN saved_partner s
		                 ON p.id=s.partner_id
		                 AND s.user_id=?";

		$subscriptions['coupons'] = self::selectPrepared($couponQuery, 'i', $userId);
		$subscriptions['auctions'] = self::selectPrepared($auctionQuery, 'i', $userId);
		$subscriptions['partners'] = self::selectPrepared($partnerQuery, 'i', $userId);

		return $subscriptions;
	}

	/**
	*
	*/
	public static function setUserNotificationAsRead($notificationId, $userId = 0) {
		$dbh = Model::give_dbh();
		$affectedRows = 0;

		if ($stmt = $dbh->prepare("UPDATE user_notification_status 
			                       SET is_read=1 
			                       WHERE user_id=?
			                       AND notification_id=?")) {
			$stmt->bind_param("ii", $userId, $notificationId);
			if ($stmt->execute()) {
				$affectedRows = $stmt->affected_rows;
			}
			else {
				// log
			}
		}
		else {
			// log
		}
		return $affectedRows;
	}
}
?>
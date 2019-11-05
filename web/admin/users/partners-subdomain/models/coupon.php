<?php
use PartnerDomain\Model;
use PartnerDomain\Messages;
use PartnerDomain\Utilities;

/**
*
*/
class CouponModel extends Model implements JsonSerializable {
	/**
	* @var int the coupon id from db
	*/
	public $id = 0; 

	/**
	* @var string the unique hash for url and notification subscriptions
	*/
	public $hash = null;

	/**
	* @var string code for digital coupons and redemptions
	*/
	public $online_code = null;

	/**
	* @var id of category placed in
	*/
	public $category_id = null;

	/**
	* @var string what category coupon belongs to
	*/
	public $category_name = null;

	/**
	* @var int id of provider who posted 
	*/
	public $partner_id = null;

	/**
	* @var string name of provider who posted 
	*/
	public $partnerName = null;

	/**
	*
	*/
	public $partnerHash = null;

	/**
	* @var string title of coupon
	*/
	public $title = null;

	/**
	* @var string a short description
	*/
	public $description = null;

	/**
	* @var int the discounted price
	*/
	public $price = null;

	/**
	* @var string start date
	*/
	public $start_date = null;

	/**
	* @var string end date
	*/
	public $end_date = null;

	/**
	* @var string restrictions
	*/
	public $restrictions = "None";

	public $photo_basenames = null;


	/**
	* constructor sets object's properties using values in the supplied array
	*/
	public function __construct($data=array()){
		parent::__construct('coupon', 'php');	
		$this->id             = (isset($data['id'])) ? (int)$data['id'] : $this->id;

		$this->hash           = (isset($data['hash'])) ? (string)$data['hash'] : $this->hash;	

		$this->online_code    = (isset($data['online_code'])) ? (string)$data['online_code'] : $this->online_code;		

		$this->category_id    = (isset($data['category_id'])) ? (int)$data['category_id'] : $this->category_id;

		$this->category_name  = (isset($data['category_name'])) ? (string) $data['category_name'] : $this->category_name ;

		$this->partner_id     = (isset($data['partner_id'])) ? (int) $data['partner_id'] : $this->partner_id ;

		$this->partnerName    = (isset($data['partner_name'])) ? (string) $data['partner_name'] : $this->partnerName;

		$this->partnerHash    = (isset($data['partner_hash'])) ? (string) $data['partner_hash'] : $this->partnerHash;
		
		$this->title       	  = (isset($data['title'])) ? (string) $data['title'] : $this->title;
		
		$this->description    = (isset($data['description'])) ? (string) $data['description']: $this->description;

		$this->price          = (isset($data['price'])) ? (string) $data['price']: $this->price;
		
		$this->start_date 	  = (isset($data['start_date'])) ? 
		    Model::getDateTime($data['start_date']) : 
		    $this->start_date;
		
		$this->end_date 	  = (isset($data['end_date'])) ? 
		    Model::getDateTime($data['end_date']) :
		    $this->end_date;
		
		$this->category_name  = (isset($data['category_name']))? (string)$data['category_name'] : $this->category_name;
		
		$this->restrictions   = (isset($data['restrictions']))? (string)$data['restrictions'] : $this->restrictions;

		$this->photo_basenames = array (
			isset($data['photo_one'])   ? $data['photo_one']   : 'default',
			isset($data['photo_two'])   ? $data['photo_two']   : 'default2',
			isset($data['photo_three']) ? $data['photo_three'] : 'default3',
			isset($data['photo_four'])  ? $data['photo_four']  : 'default4',
			isset($data['photo_five'])  ? $data['photo_five']  : 'default5',
		);	
	}

	/**
	* get coupon info combined with associated category titles and provider names and hashes
	* @return array of coupon objects
	*/
	public static function getCategorizedCoupons($limit = 1000){
		$coupons = array();

		$query = "SELECT cpn.id, cpn.hash, cpn.online_code, cat.category_name AS category_name, cpn.title, cpn.description, cpn.price, cpn.start_date, cpn.end_date, cpn.restrictions, cpn.photo_one, cpn.hash, p.name AS partner_name, p.hash AS partner_hash 
			FROM coupon cpn 
			INNER JOIN category cat
			ON cpn.category_id = cat.category_id
			INNER JOIN partner p ON cpn.provider_id=p.id 
			LIMIT ?";

		$results = self::selectPrepared($query, 'i', $limit);
		foreach ($results as $couponData) {
			$coupon = new self($couponData);
			$coupons[] = $coupon;
		}

		return $coupons;
	}

	/**
	* Returns a Coupon object matching given id 
	*
    * @param int the coupon id
    * @return CouponModel | false the provider object, or false if the record was found 
    * or there was a problem
	*/

	public static function get_by_id($id = 0){
		$dbh = Model::give_dbh();

		$q = "SELECT cpn.id, cat.category_id, cat.category_name, cpn.category_id, p.id, p.name, cpn.title, cpn.description, cpn.price, cpn.start_date, cpn.end_date, cpn.restrictions, cpn.photo_one, cpn.photo_two, cpn.photo_three, cpn.photo_four, cpn.photo_five, cpn.hash 
		      FROM coupon cpn 
		      INNER JOIN category cat 
		      ON cpn.id=?
		      AND cpn.category_id=cat.category_id
		      INNER JOIN partner p
		      ON cpn.provider_id=p.id";

		if($stmt = $dbh->prepare($q)){
			$stmt->bind_param('i', $id);
			if(!$stmt->execute()){
				Messages::set_message('Server Error: could not retrieve coupon! Please contact us regarding this issue', 'error');
			}

			$result = $stmt->get_result();
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					return new self($row);
				}
			}
			else {
				// log
			}

			$stmt->close();
			return null;
		}
	}

    /**
	* Returns a Coupon object matching given hash 
	*
    * @param string the coupon hash
    * @return CouponModel object if the record was found, null otherwise
	*/

	public static function getByHash($hash = null){
		$coupon = null;

		$query = "SELECT cpn.id, cpn.hash, cpn.online_code, cat.category_id, cat.category_name, cpn.category_id, p.id AS partner_id, p.name AS partner_name, p.hash AS partner_hash, cpn.title, cpn.description, cpn.price, cpn.start_date, cpn.end_date, cpn.restrictions, cpn.photo_one, cpn.photo_two, cpn.photo_three, cpn.photo_four, cpn.photo_five
		         FROM coupon cpn 
		         INNER JOIN category cat 
		         ON cpn.hash=?
		         AND cpn.category_id=cat.category_id
		         INNER JOIN partner p
		         ON cpn.provider_id=p.id";

		$results = self::selectPrepared($query, 's', $hash);
		if ($results[0]) {
			$coupon = new self($results[0]);
		}
		return $coupon;
	}

	/**
	* Inserts the current Coupon object into the db, and sets its ID property
	* called when Provider submits post coupon form
	* partnerId is passed directly, instead of just through post so that the notifications module can more easily
	* call this method
	* @return true on successfull insert, false otherwise
	* @testing: successful insert, changes reflected in db, error thrown on non_null ID, duplicates created
	* @return CouponModel object created
	* @todo duplicate handling
	*/

	public static function add($partnerId = 0){
		$coupon = null;

		if(isset($_POST['submit'])){ 
			$clean_post = PartnerDomain\Sanitation::clean_data($_POST);
			$clean_photos = PartnerDomain\Sanitation::clean_data($_FILES);
			$upload = array_merge($clean_post, $clean_photos);

			$coupon = new self($upload);
			$photo_upload_status = Utilities::upload_photos("partners-subdomain/assets/img/uploads/coupons", $clean_photos);
			
			$start_timestamp = Utilities::convertDateToTimestamp($coupon->start_date);
			$end_timestamp   = Utilities::convertDateToTimestamp($coupon->end_date);
			$coupon->hash    = Utilities::getUniqueHash('coupon');
			
			if ($partnerId == 0 && isset($clean_post['partner_id'])) {
				$partnerId = $clean_post['partner_id'];
			}

			$insertQuery = "INSERT INTO coupon(category_id, provider_id, title, description, price, start_date, end_date, restrictions, photo_one, photo_two, photo_three, photo_four, photo_five, hash, online_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$affectedRows = self::affectRowsPrepared($insertQuery, 'iississssssssss', $coupon->category_id,
				                                                                      $partnerId,
				                                                                      $coupon->title,
				                                                                      $coupon->description,
				                                                                      $coupon->price,
				                                                                      $start_timestamp,
				                                                                      $end_timestamp,
				                                                                      $coupon->restrictions,
				                                                                      $coupon->photo_basenames[0], 
																			    	  $coupon->photo_basenames[1],
																			    	  $coupon->photo_basenames[2],
																			    	  $coupon->photo_basenames[3],
																			   	      $coupon->photo_basenames[4],
				                                                                      $coupon->hash,
																					  $coupon->online_code)['affected_rows'];
			

			$message = array(
		    	'hash'                => $coupon->hash,
		    	'title'               => $coupon->title,
		    	'coupon_description'  => $coupon->description,
		    	'coupon_start_date'   => $coupon->start_date,
		    	'coupon_end_date'     => $coupon->end_date,
		    	'coupon_restrictions' => $coupon->restrictions,
		    	'coupon_photo_one'    => $coupon->photo_basenames[0],
		    	'partner_hash'        => $clean_post['partner_hash'],
		    	'partner_name'        => $clean_post['partner_name'],
		    	'category_hash'       => $clean_post['category_hash'],
		    	'category_name'       => $clean_post['category_name'],
		    	'submission_type'     => $clean_post['submission_type'],
		    	'content_type'        => $clean_post['content_type']
		    );
			PartnerDomain\Notification::sendNotification($message);
		}

		return $coupon;
	}

	/**
	* Update current Coupon object in database
	* called on button in coupon preferences pane
	* @return void
	*/

	public function edit(){
		if(is_null($this->id)){
			// log
			trigger_error("CouponModel::update(): Attempt to update a Coupon object that does not have its ID property set.", E_USER_ERROR);
		}

		# update coupon:
		if($stmt = self::$dbh->prepare("UPDATE coupons SET title=?, description=?, price=?, start_date=?, end_date=?, category_id=?, restrictions=?, photo=? WHERE provider_id=?")){
			$stmt->bind_param('ssssiss', $this->title, $this->description, $this->start_date, $this->end_date, $this->category_id, $this->restrictions, $this->photo );
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return false;
			}

			$success = $stmt->affected_rows;
			$stmt->close();
			$conn->close();
			return $success;
		}
	}

	/**
	*
	*/
	public function delete(){
		if($stmt = self::$dbh->prepare("DELETE FROM coupon WHERE id=?")){
			$stmt->bind_param('i', $this->id);
			$stmt->execute();
			return $stmt->affected_rows;
		}
		else {
			Messages::set_message(self::$dbh->error, 'error');
		}
	}

	/**
	* get list of a specific user's saved coupons
	* @param id - user id
	* @return array - list of coupons
	*/
	public static function get_user_saved_coupons($user_id = 0){
		$list = array();

		$db = self::give_dbh();
		
		if($stmt = $db->prepare("SELECT c.id, c.category_name, c.provider_name, c.title FROM coupon c LEFT JOIN saved_coupon sc ON sc.saved_user_id=? AND c.id=sc.saved_id")){
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc()){
				$list[] = new CouponModel($row);
			}
		}
		else {
			echo self::$dbh->error;
		}
		return $list;
	}

	/**
	*
	*/
	public function index(){
		return CouponModel::getCategorizedCoupons();
	}

	public function profile($hash){
			return CouponModel::getByHash($hash);
	}

	/**
	*
	*/
	public function show_comments(){
		
	}

	/**
	*
	*/
	public static function get_coupons($partnerId){
		$coupons = array();
		if($stmt = self::$dbh->prepare("SELECT cou.id, cou.category_id, cou.title, cou.description, cou.price, cou.start_date, cou.end_date, cou.restrictions, cou.photo, cat.category_name FROM coupons cou INNER JOIN category cat ON provider_id=? AND cou.category_id=cat.category_id")){
			$stmt->bind_param('i', $partnerId);
			$stmt->execute();
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc()){
				$coupons[] = new CouponModel($row);
			}
		}
		else{
		}
		
		return $coupons;
	}

	/**
	*
	*/
	public function jsonSerialize()
    {
        return 
        [
            'id'            => $this->id,
            'category_id'   => $this->category_id,
            'category_name' => $this->category_name,
            'partner_id'    => $this->partner_id,
            'partner_name'  => $this->partnerName,
            'title'         => $this->title,
            'description'   => $this->description,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'restrictions'  => $this->restrictions,
            'photo_one'     => $this->photo_one,
            'photo_two'     => $this->photo_two,
            'photo_three'   => $this->photo_three,
            'photo_four'    => $this->photo_four,
            'photo_five'    => $this->photo_five
        ];
    }
}
?>
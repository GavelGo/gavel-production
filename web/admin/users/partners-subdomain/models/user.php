<?php
namespace PartnerDomain;

use PartnerDomain\Model;
use PartnerDomain\Sanitation;
use PartnerDomain\Messages;

/**
* @todo check for dep injection
*/
class UserModel extends Model {
	/**
	* @var int the user id from db
	*/
	public $id = NULL; 

	/**
	* @var string first name
	*/
	public $first_name = NULL;

	/**
	* @var string last name
	*/
	public $last_name = NULL;

	
	
	/**
	* @var string email address
	*/
	public $email = NULL;

	/**
	* @var string phone number
	*/
	public $phone_number = NULL;

	/**
	* @var string date of birth
	*/
	public $dob = NULL;

	/**
	* @var string street address
	*/
	public $address_line_one = NULL;

	/**
	* @var string street address
	*/
	public $address_line_two = NULL;

	/**
	* @var string city
	*/
	public $city = NULL;

	/**
	* @var string state
	*/
	public $state = NULL;

	/**
	* @var int the user's zipcode
	*/
	public $zipcode = NULL;

	/**
	* @var array all the auctions posted by this user
	*/
	public $all_auctions = array();

	/**
	* @var array all the non-expired auctions posted by this user
	*/
	public $active_auctions = array();

	/**
	* @var array all the expired auctions posted by this user
	*/
	public $inactive_auctions = array();

	/**
	* @var array all the responses auctions posted by this user
	*/
	public $all_auction_responses = array();

	/**
	* @var array all the responses to non-expired auctions posted by this user
	*/
	public $active_auction_responses = array();

	/**
	* @var array all the responses to expired auctions posted by this user
	*/
	public $inactive_auction_responses = array();

	/**
	* @var array 	which partner the user follows
	*/
	public $provider_subscriptions = array();

	/**
	* @var array 	which categories the user watches
	*/
	public $category_subscriptions = array();

	/**
	* @var boolean	user subscription status to general emails and notifications
	*/
	public $general_updates_subscription = NULL;

	/**
	* constructor sets object's properties using values in the supplied array
	*/
	public function __construct($data=array()){
		parent::__construct('user', 'php');

		// if array element not set or empty, set to pre-existing value, since store_form_values() calls constructor and we want it to only overwrite the values changed from the edit profile page:  
		$this->id = (isset($data['user_id']) && !empty($data['user_id'])) ? (int)$data['user_id'] : $this->id;

		$this->first_name = (isset($data['user_first_name']) && !empty($data['user_first_name'])) ? (string) $data['user_first_name'] : $this->first_name;

		$this->last_name = (isset($data['user_last_name']) && !empty($data['user_last_name'])) ? (string) $data['user_last_name'] : $this->last_name;

		$this->email = (isset($data['user_email']) && !empty($data['user_email'])) ? (string) $data['user_email'] : $this->email;

		$this->phone_number = (isset($data['user_phone_number']) && !empty($data['user_phone_number'])) ? (int) $data['user_phone_number']: $this->phone_number;

		$this->dob = (isset($data['user_dob']) && !empty($data['user_dob'])) ? (string) $data['user_dob'] : $this->dob;

		$this->address_line_one = (isset($data['user_address_line_one']) && !empty($data['user_address_line_one'])) ? (string) $data['user_address_line_one'] : $this->address_line_one;

		$this->address_line_two = (isset($data['user_address_line_two']) && !empty($data['user_address_line_two'])) ? (string) $data['user_address_line_two'] : $this->address_line_two;	
		
		$this->city = (isset($data['user_city']) && !empty($data['user_city'])) ? (string) $data['user_city'] : $this->city;		

		$this->state = (isset($data['user_state']) && !empty($data['user_state'])) ? (string) $data['user_state'] : $this->state;

		$this->zipcode = (isset($data['user_zipcode']) && !empty($data['user_zipcode'])) ? (int) $data['user_zipcode'] : $this->state;

		$this->provider_subscriptions = (isset($data['provider_subscriptions']) && !empty($data['provider_subscriptions'])) ? boolval($data['provider_subscriptions']) : $this->provider_subscriptions;

		$this->category_subscriptions = (isset($data['category_subscriptions']) && !empty($data['category_subscriptions'])) ? boolval($data['category_subscriptions']) : $this->category_subscriptions;

		$this->general_updates_subscription = (isset($data['general_updates_subscription']) && !empty($data['general_updates_subscription'])) ? boolval($data['general_updates_subscription']) : $this->general_updates_subscription;

	}

	/**
	* return current objects properties
	* @return array - current objects properties
	* @access public
	*/
	public function get_object_properties(){
		return get_object_vars($this);
	}

	/**
	* Sets object's properties using the edit from post values in the supplied array
	*
	* @param associative array - the form post values
	*/

	public function store_form_values($form_values){
		// store all params
		$this->__construct($form_values);
	}

	/**
	* takes cleaned user info and inserts
	* @param string - first name
	* @param string - last name
	* @param string - email
	* @param string - password
	* @return void
	*/
	public static function add(string $firstName, string $lastName, string $email, string $password){
		if($stmt = self::$dbh->prepare("INSERT INTO users(user_first_name, user_last_name, user_email, user_password_hash) VALUES(?,?,?,?)")){
			$stmt->bind_param('ssss', $firstName, $lastName, $email, $password);

			if(!$stmt->execute()){
				$stmt->close();
				throw new RegistrationException("Could not add user!");
				exit();
			}
			$stmt->close();
		}	
		else{
			throw new RegistrationException("Query could not be prepared!");
			// user friendly message
		}
	}

	/**
	* Update current User object in database
	* called on button in user preferences pane
	* @return true on update success | false on failure
	*/

	public function update(){
		// does Provider object have ID?
		if(is_null($this->id)){
			trigger_error("User::update(): Attempt to update a User object that does not have its ID property set.", E_USER_ERROR);
		}

		if($stmt = self::$dbh->prepare("UPDATE users SET user_first_name=?, user_last_name=?, user_username=?, user_email=?, user_dob=?, user_address_line_one=?, user_address_line_two=?, user_city=?, user_state=?, user_gender=? WHERE user_id=?")){
			$stmt->bind_param('ssssssssssi', $this->first_name, $this->last_name, $this->username, $this->email, $this->dob, $this->address_line_one, $this->address_line_two, $this->city, $this->state, $this->gender, $this->id);
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			return $stmt->affected_rows;	
		}
		return 0;
	}

	public function index(){
		return;
	}

	public function check_for_remember(){

	}

	/**
	* Returns a UserModel object matching given id
	*
    * @param string the username
    * @return User|false the provider object, or false if the record was found or there was a problem
	*/
	public static function get_by_id($id = 0){
		$db_handle = Model::give_dbh();
		
		if($stmt = $db_handle->prepare("SELECT user_id, user_first_name, user_last_name, user_email, user_phone_number, user_dob, user_address_line_one, user_address_line_two, user_city, user_state, user_zipcode FROM users WHERE user_id=?")){
			$stmt->bind_param('i', $id);
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					return new self($row);
				}
			}
			$stmt->close();
			return null;
		}
	}

	/**
	* Returns a UserModel object matching given username 
	*
    * @param string the username
    * @return User|false the provider object, or false if the record was found or there was a problem
	*/
	public static function get_by_name($username = ''){
		$db_handle = Model::give_dbh();
		
		if($stmt = $db_handle->prepare("SELECT * FROM users WHERE user_username=?")){
			$stmt->bind_param('s', $username);
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					return new self($row);
				}
			}
			else {
				// Throw no user found exeception
				echo "<br />No User with given username: " . $username;
			}
			return null;
			$stmt->close();
		}
	}

	/**
	* Returns a UserModel object matching given email 
	*
    * @param string the username
    * @return User|false the provider object, or false if the record was found or there was a problem
	*/

	public static function get_by_email(string $email = ''){
		if($stmt = self::$dbh->prepare("SELECT * FROM users WHERE user_email=?")){
			$stmt->bind_param('s', $email);
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					return new self($row);
				}
			}
			// no user found
			$stmt->close();
			return null;
		}
	}

	/**
	*
	*/
	public function logout(){
		HomeModel::logout();
		// if(empty(session_id())){
		// 	session_start();    // Load the old session
		// }

		// // If it's desired to kill the session, also delete the session cookie.
		// // Note: This will destroy the session, and not just the session data!
		// if (ini_get("session.use_cookies")) {
  //       	$params = session_get_cookie_params();
  //       	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
  //       	// echo "<br />use only";
  //   	}
		// // Finally, destroy the session.
		// // session_destroy — Destroys all data registered to a session
		// // bool session_destroy ( void )
		// session_destroy();
  //      	session_unset();    		  // Delete its contents
  //   	session_start();    		  // Create a new session
  //   	session_regenerate_id(true);  // Ensure it has a new id
  //   	session_write_close();  	  // Convince it to write
		// Messages::set_message('You have been logged out!');
  //   	$_SESSION['logged_in'] = 0;
	}

	public function edit_profile($post) {
		$clean_post_data = array();
		foreach ($post as $key => $value) {
			$clean_post_data[$key] = Sanitation::clean_data($value);
		}

		$user->store_form_values($clean_post_data);
		switch($user->update()){
			case -1:
				Messages::set_message('Error Updating Profile', 'error');
				break;
			case 0:
				Messages::set_message('No Changes made to Profile', 'error');
				break;
			case 1:
				Messages::set_message('Update Profile successful!');
				break;
			default:
				break;
		}
	}

	public function profile($id = 0){
		$user = self::get_by_id($id);
		if(!is_null($user)){
			$user->get_provider_subscriptions();
		}

		if(isset($_POST['submit_update'])){
			$user->edit_profile($_POST);
		}

		if(isset($_POST['submit_change_password'])){
			$clean_post_data = array();
				foreach ($_POST as $key => $value) {
					$clean_post_data[$key] = Sanitation::clean_data($value);
				}
				$clean_post_data['hashed_new_password'] = password_hash(Sanitation::clean_data($clean_post_data['new_password']), PASSWORD_DEFAULT);

			$auth_status = (Auth::check_password($_SESSION['user_id'], $clean_post_data['current_password']))? 1 : 0;
			if($auth_status){
				var_dump($user->change_password($clean_post_data['hashed_new_password']));
			}
			else {
				Messages::set_message('Incorrect current password', 'error');
			}
		}
		return $user;
	}

	/**
	* @assumes input of current password is verified
	* @return 1 - successful change | 0 - failed change(due to empty new password or query failure)
	*/
	public function change_password($password){
		// redundant emptiness check
		if(!empty($password)){
			if($stmt = self::$dbh->prepare("UPDATE users SET user_password_hash=? WHERE user_id=?")){
				$stmt->bind_param('si', $password, $this->id);
				$stmt->execute();
				return $stmt->affected_rows;
			}
		}
		else {
			Messages::set_message('No new password given', 'error');
		}
		return 0;
	}

	/**
	*  which partner the user is subscribed to
	* @return array 
	*/
	public function get_provider_subscriptions(){
		$subs = array();
		if($stmt = self::$dbh->prepare("SELECT s.partner_id FROM partner p INNER JOIN user_partner_subscription s WHERE p.id=s.partner_id AND s.user_id=?")){
			$stmt->bind_param('i', $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows != 0){
				while($row = $result->fetch_assoc()){
					$subs[$row['provider_id']] = $row['provider_name'];
				}	
			}
		}
		else {
			// temp
			echo "<br /><h1>" . $this->id . "Could not get subscriptions!</h1>";
			echo self::$dbh->error;
		}
		$this->provider_subscriptions = $subs;
	}

	/**
	*
	*/
	public function get_category_subscriptions(){
		$subs = array();

		// $query = "SELECT c.category_name AS all_categories_name, cat.category_name AS subscribed_category_name, s.category_subscription_id FROM categories c LEFT JOIN categories cat ";
		if($stmt = self::$dbh->prepare("SELECT c.category_id, c.category_name, s.category_subscription_id FROM categories c INNER JOIN user_category_subscriptions s WHERE c.category_id=s.category_subscription_category_id AND s.category_subscription_user_id=?")){
			$stmt->bind_param('i', $this->id);
			$stmt->execute();
			$result = $stmt->get_result();

			if($result->num_rows === 0){
				echo "<br />No subscriptions. Click here{href} to add some.";
			}
			else {
				while($row = $result->fetch_assoc()){
					$subs[$row['category_id']] = array('category_name' => $row['category_name'], 'category_id' => $row['category_id']);
				}	
			}
		}
		else {
			echo "<br />Could not get subscriptions!";
			echo self::$dbh->error;
		}
		$this->category_subscriptions = $subs;
	}

	/**
	* called by user_handler called by ajax on provider profile or maybe coupon or auction page to save review to db
	* @param string review
	* @param int rating
	* @param int would recommend 
	* @return 1 success, 0 failure
	*/
	public function leave_review($provider_id, $review, $rating, $would_recommend){
		if(is_null($this->id)){
			// temp: 
			trigger_error("User::leave_review(): Attempt to update a User object that does not have its ID property set.", E_USER_ERROR);
			// final:
			// return "No user id set! Please log back in.";
			// or
			// return 0
		}

		if(!empty($provider_id) && !empty($review) && !empty($rating) && $would_recommend){
			if($stmt = self::$dbh->prepare("INSERT INTO provider_review(provider_review_provider_id, provider_review_user_id, provider_review_rating, provider_review_review, provider_review_would_recommend) VALUES(?,?,?,?,?)")){
				$stmt->bind_param('iiisi', $provider_id, $this->id, $rating, $review, $would_recommend);
				if(!$stmt->execute()){
					echo self::$dbh->error;
					
					return 0;
				}
				return $stmt->affected_rows;
			}
			else {
				echo self::$dbh->error;
			}
		}
		return 0;
	}

	/**
	*
	*/
	public function isPartnerSaved($partnerId){
		$query = "SELECT COUNT(*) AS count
		          FROM saved_partner
		          WHERE saved_partner_Id=?
		          AND saved_partner_user_id=?";
		return Model::selectPrepared($query, 'ii', $partnerId, $userId)[0]['count'];
	}

	/**
	* saves/bookmarks provider in db for current user
	* @access public
	* @uses UserModel::ispartneraved()
	* @param int provider id
	* @return -1 or 0 on error, 1 on success, 2 on redundant 
	*/
	public function savePartner($partnerId){
		$query = "INSERT INTO saved_partner(saved_partner_id, saved_partner_user_id)
		          VALUES(?,?)";
		if ($this->id == 0 || $partnerId == 0) {
			// log
			// user message
			return -1;
		}
		return Model::affectRowsPrepared($query, 'ii', $partnerId, $this->id);
	}

	/**
	* unsaves provider in db for current user
	* @access public
	* @uses UserModel::provider_is_saved()
	* @param int provider id
	* @return -1 or 0 on error, 1 on success, 2 on redundant 
	*/
	public function unsavePartner($partnerId){
		$query = "DELETE FROM saved_partner
				  WHERE saved_partner_id=?
				  AND saved_partner_user_id=?";
		if ($this->id == 0 || $partnerId == 0) {
			// log
			// user message
			return -1;
		}
		return Model::affectRowsPrepared($query, 'ii', $partnerId, $this->id);
	}

	/**
	* 
	*/
	public function isCouponSaved($couponId){
		$query = "SELECT COUNT(*) AS count
		          FROM saved_coupon
		          WHERE saved_coupon_coupon_id=?
		          AND saved_coupon_user_id=?";
		return Model::selectPrepared($query, 'ii', $couponId, $this->id)[0]['count'];
	}

	/**
	* function to bookmark/save coupon
	* called by coupon ajax handler on save button press on coupon profile page
	*/
	public function saveCoupon($couponId = 0){
		$query = "INSERT INTO saved_coupon(saved_coupon_coupon_id, saved_coupon_user_id)
		          VALUES(?,?)";
		if ($this->id == 0 || $couponId == 0) {
			// log
			// user message
			return -1;
		}
		return Model::affectRowsPrepared($query, 'ii', $couponId, $this->id);
	}

	/**
	* function to unbookmark/unsave coupon
	* called by coupon ajax handler on unsave button press on coupon profile page
	*/
	public function unsaveCoupon($couponId = 0){
		$query = "DELETE FROM saved_coupon
				  WHERE saved_coupon_coupon_id=?
				  AND saved_coupon_user_id=?";
		if ($this->id == 0 || $couponId == 0) {
			// log
			// user message
			return -1;
		}
		return Model::affectRowsPrepared($query, 'ii', $couponId, $this->id);
	}
}
?>
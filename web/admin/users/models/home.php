<?php
use PartnerDomain\Model;
use PartnerDomain\Messages;
use PartnerDomain\Sanitation;
use PartnerDomain\UserModel;
/**
*
*/
class HomeModel extends Model {
	public static function login(){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1){
			Messages::set_message('You are already logged in');
			return;
		}

		if(isset($_POST['submit'])){
			$clean_post_data = Sanitation::clean_data($_POST);

			try {
				$user_id = Authentication::check_user_credentials($clean_post_data['user_email'], $clean_post_data['user_password']);
				if($user_id !== 0){ 
					// current session has email
					// render current session obsolete, but do not delete so as to support concurrent connections and unstable network connections and malicious access attempts 
					// must set short term expiration time (time-stamp) -- set to 1 minute
					$_SESSION['IS_OBSOLETE'] 		   = 1;
					$_SESSION['IS_LOCKED'] 			   = 1;
					$_SESSION['EXPIRES'] 			   = time() + 60;
					// regen id to avoid session hijacking and locking, but DO NOT delete old session:
					session_regenerate_id();
					$_SESSION['logged_in'] 			   = 1;

					// get partner info
					$user = UserModel::get_by_id($user_id);				
					$_SESSION['user_id'] 	       	       = $user->id;
					$_SESSION['user_email'] 		   	   = $clean_post_data['user_email'];
					$_SESSION['user_first_name']          	   = $user->first_name;
					$_SESSION['user_last_name']          	   = $user->last_name;
					$_SESSION['last_active'] 		   	   = time();
					$_SESSION['CREATED'] 			   	   = time();

					$_SESSION['_USER_AGENT']           	   = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION['_USER_ACCEPT']          	   = $_SERVER['HTTP_ACCEPT'];
					$_SESSION['_USER_ACCEPT_ENCODING'] 	   = $_SERVER['HTTP_ACCEPT_ENCODING'];
					$_SESSION['_USER_ACCEPT_LANG']     	   = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
					if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])){
						$_SESSION['_USER_ACCEPT_CHARSET']  = $_SERVER['HTTP_ACCEPT_CHARSET'];
					}
					// Only use the first two blocks of the IP (loose IP check). Use a
					// netmask of 255.255.0.0 to get the first two blocks only.
					// won't screw over proxy users but will catch anyone quickly changing countries
					$_SESSION['USER_LOOSE_IP'] = long2ip(ip2long($_SERVER['REMOTE_ADDR']) & ip2long("255.255.0.0"));

					unset($_SESSION['IS_OBSOLETE']);
					unset($_SESSION['IS_LOCKED']);

					header("Location: " . CUST_ROOT_URL);
					exit();
				}
				else {
					Messages::set_message("Incorrect Login", 'error');
				}
			} catch(Exception $e){
				// log
			}
		}
		return;
	}

	public function notifications() {
		return;
	}

	/**
	*
	*/
	public static function logout(){
		SessionManager::end_session();
	}

	/**
	* @todo don't set status = 1, send email for user to activate account
	* @return 
	*/
	public static function register(){
		if(isset($_POST['submit'])){
			$clean_post_data = Sanitation::clean_data($_POST);

			// hash password
			$hashed_password = password_hash($clean_post_data['user_password'], PASSWORD_DEFAULT);

			$db_handle = Model::give_dbh();
			// check if email already exists 
			if($stmt = $db_handle->prepare("SELECT user_email FROM users WHERE user_email=?")){
				$stmt->bind_param('s', $clean_post_data['user_email']);
				if(!$stmt->execute()){
					Messages::set_message('Server Error: could not check email', 'error');
				}
				else {
					$result = $stmt->get_result();

					if($result->num_rows === 1){
						Messages::set_message('A user with this email already exists. Please use a different email address', 'error');
					}
					else if($result->num_rows === 0){
						// email input is unique so insert provider
						if($stmt = self::$dbh->prepare("INSERT INTO users SET user_first_name=?, user_last_name=?, user_email=?, user_password_hash=?, user_status=1")){
							$stmt->bind_param('ssss', $clean_post_data['user_first_name'], $clean_post_data['user_last_name'], $clean_post_data['user_email'], $hashed_password);
							if (!$stmt->execute()) {
								// log
								// user friendly message
							}

							// action according to insert success status 
							switch ($stmt->affected_rows) {
								case -1:
									Messages::set_message('Error', 'error');
									break;
								case 0:
									Messages::set_message('No Insert!', 'error');
									break;
								case 1:
									$_SESSION['registration_email'] = $clean_post_data['user_email'];
									header("Location: /");
									break;
								default:
									break;
							}
						}
					}
					else {
						Messages::set_message('Could not check email', 'error');
					}
				}
			}

		}	
	}

	/**
	*
	*/
	public function activate($request = array()){
		// match query string token against stored token
		// similar to the same function in the partners home model
	}

	/**
	* featured items
	*/
	public function index(){
		return;
	}

	public function explore(){
		$featuredItems = array(
			'coupons'    => array(),
			'auctions'   => array(),
			'partners'   => array(),
			'categories' => array()
		);
	
		// in the future, the "featured" products and auctions will be calculated
		// for now, just return first few in tables
		$featuredItems['coupons']    = CouponModel::getCategorizedCoupons(12);
		// auctions
		// $featuredItems['auctions']   = AuctionModel::getFeaturedAuctions(12);
		// partners
		// $featuredItems['partners']   = PartnerModel::getFeaturedPartners(12);
		// categories
		// $featuredItems['categories'] = CategoryModel::getCategoryNames();
		
		return $featuredItems;
	}

	public function support(){
		return;
	}

	public function feedback(){
		return;
	}

	public function contact(){
		return;
	}

	public function notfound(){
		return;
	}

	public function info(){
		return;
	}

	public function terms(){
		return;
	}

	public function careers(){
		return;
	}

	public function recover(){
		return;
	}

	public function comingsoon(){
		return;
	}

	public function gavelgo(){
		return;
	}
}
?>
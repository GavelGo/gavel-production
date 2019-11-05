<?php
use PartnerDomain\Model;
use PartnerDomain\Messages;
/**
*
*/
class HomeModel extends Model {
	public static function login(){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['partner_name'])){
			Messages::set_message('You are already logged in as ' . $_SESSION['partner_name']);
			return;
		}

		if(isset($_POST['submit'])){
			$clean_post_data = Sanitation::clean_data($_POST);

			try{
				$partner_id = Authentication::check_credentials($clean_post_data['email'], $clean_post_data['password']);
				if($partner_id !== 0){ 
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
					 $partner = PartnerModel::get_by_email($clean_post_data['email']);
					$_SESSION['partner_category_id'] 	   = $partner->category_id;
					$_SESSION['partner_id'] 	       	   = $partner->id;
					$_SESSION['account_email'] 		   	   = $clean_post_data['email'];
					$_SESSION['partner_name']          	   = $partner->name;
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

					header("Location: " . ROOT_URL);
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
	* @todo need to return result code 
	* @return 
	*/
	public static function register(){
		if(isset($_POST['submit'])){
			$clean_post_data = Sanitation::clean_data($_POST);

			// hash password
			$hashed_password = password_hash($clean_post_data['account_password'], PASSWORD_DEFAULT);

			$db_handle = Model::give_dbh();
			// check if email already exists: 
			if($stmt = $db_handle->prepare("SELECT account_email FROM partner WHERE account_email=?")){
				$stmt->bind_param('s', $clean_post_data['account_email']);
				if(!$stmt->execute()){
					Messages::set_message('Server Error: could not check email', 'error');
				}
				else {
					$result = $stmt->get_result();

					if($result->num_rows === 1){
						Messages::set_message('A Partner with this email already exists. Please use a different email address', 'error');
					}
					else if($result->num_rows === 0){
						// email input is unique so insert provider
						if($stmt = self::$dbh->prepare("INSERT INTO partner SET provider_name=?, account_email=?, account_password_hash=?, provider_status=0")){
							$stmt->bind_param('sss', $clean_post_data['provider_name'], $clean_post_data['account_email'], $hashed_password);
							$stmt->execute();

							// action according to insert success status: 
							switch ($stmt->affected_rows) {
								case -1:
									Messages::set_message('Error', 'error');
									break;
								case 0:
									Messages::set_message('No Insert!', 'error');
									break;
								case 1:
									$_SESSION['registration_email'] = $clean_post_data['account_email'];
									header("Location: /verify");
									break;
								default:
									// code...
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
	public function verify(){
		
		$token = bin2hex(random_bytes(30));

		if(isset($_SESSION['registration_email'])){
			/*
			if($stmt = self::$dbh->prepare("UPDATE providers SET account_token=? WHERE account_email=?")){
				$stmt->bind_param('s', $token, $_SESSION['registration_email']);
				$stmt->execute();
				switch ($stmt->affected_rows) {
					case -1:
						Messages::set_message('Error', 'error');
						break;
					case 0:
						Messages::set_message('Could not insert token!', 'error');
					case 1:
						$url = ROOT_URL . 'activate/' . $token;
						$message = "Thank you for creating a partner account with Gavelgo! On behalf of all of us, we welcome you. Please follow the link below to activate your account.\n\n" . $url;
						mail($_SESSION['registration_email'], "Gavelgo | Activate Partner Account", $message);
						//unset($_SESSION['registration_email']);
						session_unset();
						session_destory();
						break;
					default:
						// code...
						break;
				}
			}
			*/
		}
	}

	/**
	*
	*/
	public function activate($request = array()){
		// match query string token against stored token
		$clean_request = array();
		foreach ($request as $key => $value) {
			$clean_request[$key] = Sanitation::clean_data($value);
		}

		if($stmt = self::$dbh->prepare("UPDATE partner SET account_status=1, provider_token=NULL WHERE provider_token=? AND provider_name=?")){
			$stmt->bind_param('ss', $clean_request['param_two'], $clean_request['param_two']);
			if(!$stmt->execute()){
				Messages::set_message("Error: could not activate account", 'error');
			}
			return $stmt->affected_rows;
		}

		return 0;
	}

	/**
	* featured items
	*/
	public function index(){
		return;
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
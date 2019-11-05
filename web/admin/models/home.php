<?php
// THIS IS OLD
/**
*
*/
class HomeModel extends Model{
	/**
	*
	*/
	public function index(){
		return;
	}

	/**
	*
	*/
	public function login(){
		# echo "<br />home model login()";
		# print_r($_SESSION);
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['admin_name'])){
			Messages::set_message('You are already logged in as ' . $_SESSION['admin_name']);
			# Don't want to re-authenticate: 
			return;
		}
		if(isset($_POST['submit'])){
			# echo "<br />submitted!";
			$clean_post_data = array();
			foreach ($_POST as $key => $value) {
				$clean_post_data[$key] = Sanitation::clean_data($value);
			}
			# Test:
			# echo "<br /><br /><br /><br />post_data(): ";
			# print_r($clean_post_data);

			try{
				# FIX: 
				#$auth = new Authentication();
				#var_dump($auth);
				$admin_id = Authentication::check_credentials($clean_post_data['email'], $clean_post_data['password']);
				# var_dump($admin_id);
				# ===
				if($admin_id !== 0){ 
					# print_r($_SERVER);
					# current session has email
					# render current session obsolete, but do not delete so as to support concurrent connections and unstable network connections and malicious access attempts 
					# must set short term expiration time (time-stamp) -- set to 1 minute
					$_SESSION['IS_OBSOLETE'] 		   = 1;
					$_SESSION['IS_LOCKED'] 			   = 1;
					$_SESSION['EXPIRES'] 			   = time() + 60;
					
					# regen id to avoid session hijacking and locking, but DO NOT delete old session:
					# session_regenerate_id();
					
					$_SESSION['logged_in'] 			   = 1;

					# get partner info:
					$employee = EmployeeModel::get_by_email($clean_post_data['email']);
					$_SESSION['admin_id'] 	           = $employee->id;
					$_SESSION['admin_full_name']      = $employee->full_name;

					$_SESSION['LAST_ACTIVITY'] 		   = time();
					$_SESSION['CREATED'] 			   = time();

					$_SESSION['USER_AGENT']           = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION['USER_ACCEPT']          = $_SERVER['HTTP_ACCEPT'];
					$_SESSION['USER_ACCEPT_ENCODING'] = $_SERVER['HTTP_ACCEPT_ENCODING'];
					$_SESSION['USER_ACCEPT_LANG']     = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
					if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])){
						$_SESSION['USER_ACCEPT_CHARSET']  = $_SERVER['HTTP_ACCEPT_CHARSET'];
					}
					# Only use the first two blocks of the IP (loose IP check). Use a
					# netmask of 255.255.0.0 to get the first two blocks only.
					# won't screw over proxy users but will catch anyone quickly changing countries
					$_SESSION['USER_LOOSE_IP'] = long2ip(ip2long($_SERVER['REMOTE_ADDR']) & ip2long("255.255.0.0"));

					unset($_SESSION['IS_OBSOLETE']);
					unset($_SESSION['IS_LOCKED']);

					# Messages::set_message('Welcome, ' .  $_SESSION['employee_name'] . '!');
					header("Location: " . ROOT_URL);
					exit();

				}
				else {
					Messages::set_message("Incorrect Login", 'error');
				}
			} catch(Exception $e){
				Messages::set_message('Exception thrown: error authenticating user', 'error');
			}
		}
		return;
	}

	/**
	*
	*/
	public function logout(){
		# http://www.php-rocks.com/sessions.php
		# if (empty(session_id()){ 
		# 	echo "You have no session"; 
		# }
		# https://stackoverflow.com/questions/14329685/php-session-regeneration-security
		if(empty(session_id())){
			session_start();    # Load the old session
		}

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
        	$params = session_get_cookie_params();
        	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        	# echo "<br />use only";
    	}
		# Finally, destroy the session.
		# session_destroy — Destroys all data registered to a session
		# bool session_destroy ( void )
		session_destroy();
       	session_unset();    		  # Delete its contents
    	session_start();    		  # Create a new session
    	session_regenerate_id(true);  # Ensure it has a new id
    	# $_SESSION['FLASH'] = "You've been logged out";
    	session_write_close();  	  # Convince it to write
    	Messages::set_message('You have been logged out!');
    	$_SESSION['logged_in'] = 0;
    	# print_r($_SESSION);
	}

	/**
	*
	*/
	public function register(){
		echo "<br />home model register()";
		return;
	}

	/**
	*
	*/
	public function support(){
		echo "<br />home model support()";
		return;
	}

	/**
	*
	*/
	public function notfound(){
		# echo "<br />home model notfound()";
		return;
	}


}
?>
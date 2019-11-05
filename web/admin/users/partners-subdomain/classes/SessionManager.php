<?php
/**
* class to create, destory, check, and modify sessions
* @todo consolidate, unify, call all relevant checking functions into check_session, so can check all aspects at once on every request
*/

/**
* http://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
*/

//namespace PartnerDomain\SessionManager;

class SessionManager{

	private static $_ACTIVE_SESSION_STATUS = 1;
	private static $_INACTIVE_SESSION_STATUS = 2;

	/**
	* set necessary user session fields
	* moved here from user.php, so can be called 
	* in situations other than login
	*/
	public static function start_user_session($clean_post_data){
		// current session has email
		// render current session obsolete, but do not delete so as to support concurrent connections and unstable network connections and malicious access attempts 
		// must set short term expiration time (time-stamp) -- set to 1 minute
		$_SESSION['IS_OBSOLETE'] 		   = 1;
		$_SESSION['IS_LOCKED'] 			   = 1;
		$_SESSION['EXPIRES'] 			   = time() + 60;
		// regen id to avoid session hijacking and locking, but DO NOT delete old session:
		session_regenerate_id();

		self::set_basic_session_info();
		$_SESSION['logged_in'] 			   = 1;
		// $_SESSION['user_id']			   = $user_id;
		$_SESSION['user_email'] 		   = $clean_post_data['email'];
	}

	public static function start_partner_session(){

	}

	/**
	* called on home page because we want to know some info
	* about them, like IP, even if they aren't logged in
	*/
	static function start_visitor_session(){
		// make sure any old sessions left active are deactivated
		if(session_status() === $_INACTIVE_SESSION_STATUS){
			self::end_session();
		}
		self::sessionStart("visitor");
		self::set_basic_session_info();
	}

	static function set_basic_session_info(){
		$_SESSION['_USER_LAST_ACTIVITY']   = time();
		$_SESSION['SESSION_START_TIME']    = time();
		$_SESSION['_USER_IP']			   = $_SERVER['REMOTE_ADDR'];
		$_SESSION['_USER_AGENT']           = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['_USER_ACCEPT']          = $_SERVER['HTTP_ACCEPT'];
		$_SESSION['_USER_ACCEPT_ENCODING'] = $_SERVER['HTTP_ACCEPT_ENCODING'];
		$_SESSION['_USER_ACCEPT_LANG']     = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		
		if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])){
			$_SESSION['_USER_ACCEPT_CHARSET']  = $_SERVER['HTTP_ACCEPT_CHARSET'];
		}
		// Only use the first two blocks of the IP (loose IP check). Use a
		// netmask of 255.255.0.0 to get the first two blocks only.
		// won't screw over proxy users but will catch anyone quickly changing countries
		$_SESSION['USER_LOOSE_IP'] 		   = long2ip(ip2long($_SERVER['REMOTE_ADDR']) & ip2long("255.255.0.0"));

		$_SESSION['IS_OBSOLETE'] 		   = 0;
		$_SESSION['IS_LOCKED'] 			   = 0;		
	}

	/**
	*
	*/
	public static function setRegisteredSession($email){
		$_SESSION['user_email'] = $email;
		$_SESSION['registration_success'] = 1;
		$_SESSION['logged_in'] = 1;
	}

	static function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null){
		// Set the session name
		session_name($name . '_session');

		// Set SSL level
		$https = is_null($secure) ? $secure : isset($_SERVER['HTTPS']);

		// Set session cookie options
		session_set_cookie_params($limit, $path, $domain, $https, true);
		session_start();

		// Make sure the session hasn't expired, and destroy it if it has
		//if(self::validateSession())
		//{
			// Check to see if the session is new or a hijacking attempt
		//	if(!self::preventHijacking())
	//		{
				// Reset session data and regenerate id
	//			$_SESSION = array();
	//			$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
	//			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
	//			self::regenerateSession();

			// Give a 5% chance of the session id changing on any request
	//		}elseif(rand(1, 100) <= 5){
	//			self::regenerateSession();
	//		}
	//	}else{
	//		$_SESSION = array();
	//		session_destroy();
	//		session_start();
	//	}
	}

	/**
	*
	*/
	static function set_access_level(){
		// call Authentication::get_account_access_leve()
		// $_SESSION['access_level'] = Authentication::get_account_access_level();
	}
	
	static protected function preventHijacking(){
		if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])){
			return false;
		}

		if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']){
			return false;
		}

		if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']){
			return false;
		}

		return true;
	}

	/**
	*
	*/
	static function regenerate_session(){
		// If this session is obsolete it means there already is a new id
		if(isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] === 1){
			return;
		}

		// Set current session to expire in 10 seconds
		$_SESSION['OBSOLETE'] = 1;
		$_SESSION['EXPIRES']  = time() + 10;

		// Create new session without destroying the old one
		session_regenerate_id(false);

		// Grab current session ID and close both sessions to allow other scripts to use them
		$new_session_id = session_id();
		session_write_close();

		// Set session ID to the new one, and start it back up again
		session_id($new_session_id);
		session_start();

		// Now we unset the obsolete and expiration values for the session we want to keep
		//unset($_SESSION['OBSOLETE']);
		$_SESSION['OBSOLETE'] = 0;
		//unset($_SESSION['EXPIRES']);
		//$_SESSION['EXPIRES'] = 0;
	}

	/**
	* 
	* @return true if session validated
	*/
	static public function is_session_valid()
	{
		if( isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] === 1){
			return false;
		}

		if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()){
			return true;
		}

		return false;
	}








	/**
	* @todo change exceptions to Message 
	*/
	public static function checkSession(){
	    try{
	        if($_SESSION['OBSOLETE'] && ($_SESSION['EXPIRES'] < time()))
	            throw new Exception('Attempt to use expired session.');

	        if(!is_numeric($_SESSION['user_id']))
	            throw new Exception('No session started.');

	        //if($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
	        //    throw new Exception('IP Address mixmatch (possible session hijacking attempt).');

	        if($_SESSION['_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'])
	            throw new Exception('Useragent mixmatch (possible session hijacking attempt).');

	        //if(!$this->loadUser($_SESSION['user_id']))
	        //    throw new Exception('Attempted to log in user that does not exist with ID: ' . $_SESSION['user_id']);

	        if(!$_SESSION['OBSOLETE'] && mt_rand(1, 100) == 1)
	        {
	            self::regenerateSession();
	        }

	        return true;

	    }catch(Exception $e){
	        return false;
	    }
	}









	/**
	* function to check if user associated with current session has permission to access page
	* @return true if session access level is greater than or equal to page access level
	* @todo maybe move to Auth.php
	*/
	public static function check_session_permissions($current_level, $minimum_level){
		// not authorized if session empty, expired, obsolete, no user id:
		// if checkSession() && SESSION[access level] > 0, return true
		// return false
	}



















	public static function restart_session(){
		// Destroy and start a new session
		// Same as $_SESSION = array();
	    session_unset();
	    // Destroy session on disk
	    session_destroy();
	    session_start();
	    session_regenerate_id(true);
	    
	    $_SESSION['SESSION_START_TIME'] = time();
	    $_SESSION['logged_in'] = 0;
	}


	public static function end_session(){
		session_unset();
	    session_destroy();

	    /*
		// http://www.php-rocks.com/sessions.php
		// if (empty(session_id()){ 
		// 	echo "You have no session"; 
		// }
		// https://stackoverflow.com/questions/14329685/php-session-regeneration-security
		if(empty(session_id())){
			session_start();    // Load the old session
		}

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
        	$params = session_get_cookie_params();
        	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        	// echo "<br />use only";
    	}
		// Finally, destroy the session.
		// session_destroy — Destroys all data registered to a session
		// bool session_destroy ( void )
		session_destroy();
       	session_unset();    		  // Delete its contents
    	session_start();    		  // Create a new session
    	session_regenerate_id(true);  // Ensure it has a new id
    	// $_SESSION['FLASH'] = "You've been logged out";
    	session_write_close();  	  // Convince it to write
    	Messages::set_message('You have been logged out!');
    	$_SESSION['logged_in'] = 0;
    	// print_r($_SESSION);
	    */
	}

	/**
	* should not delete old session data immediately using
	* session_regenerate_id(true)
	* this function removes access to old session and removes all of its 
	* clearance levels
	*/
	public static function restrict_old_session(){
		// potential
		$_SESSION['IS_LOCKED'] = 1;
	}


	// SNIPS
	// https://wblinks.com/notes/secure-session-management-tips/
	// on login

	// won't screw over proxy users but will catch anyone quickly changing countries

	/**
	* if loose ip, user agent, http accrpt, http accept encoding, http accept language, or http accept charset have changed, end session
	*/
	public static function check_for_suspicious_activity(){
		if($_SESSION['_USER_LOOSE_IP'] != long2ip(ip2long($_SERVER['REMOTE_ADDR']) & ip2long("255.255.0.0")) 
			|| $_SESSION['_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']
    		|| $_SESSION['_USER_ACCEPT'] != $_SERVER['HTTP_ACCEPT']
    		|| $_SESSION['_USER_ACCEPT_ENCODING'] != $_SERVER['HTTP_ACCEPT_ENCODING']
    		|| $_SESSION['_USER_ACCEPT_LANG'] != $_SERVER['HTTP_ACCEPT_LANGUAGE']
    		|| $_SESSION['_USER_ACCEPT_CHARSET'] != $_SERVER['HTTP_ACCEPT_CHARSET']){
			// UserModel::reauthenticate();
			self::restart_session();
			//self::end_session();

    		// Log for attention of admin
			// Log::create("suspic", LOG::ACTIONS['NOTIFY_ADMIN']);
    		// return true;
		}
		// return false;
	}

	/**
	* may be handled in php.ini
	*/
	public static function check_session_source(){
		if(!isset($_SESSION['MY_SERVER_GENERATED_THIS_SESSION'])){
			self::restart_session();
		}
		$_SESSION['MY_SERVER_GENERATED_THIS_SESSION'] = true;
	}




// https://stackoverflow.com/questions/520237/how-do-i-expire-a-php-session-after-30-minutes?rq=1
	public static function is_session_timed_out(){
		// if user logged in and last activty was more than 30 minutes ago
		if (isset($_SESSION['_USER_LAST_ACTIVITY']) && (time() - $_SESSION['_USER_LAST_ACTIVITY'] > 1800)) {
    		// last request was more than 30 minutes ago
    		//session_unset();     // unset $_SESSION variable for the run-time 
    		//session_destroy();   // destroy session data in storage
    		self::restart_session();
    		return true;
		}
		// $_SESSION['_USER_LAST_ACTIVITY'] = time(); // update last activity time stamp
		return false;
	}

	/**
	* regenerate session id if session longer than 30 minutes
	* may combine with other functions that check time and 
	* wheter obsolete
	* @return true if time length within 30 minute boundary
	*/
	public static function prevent_fixation(){
		if (!isset($_SESSION['SESSION_START_TIME'])) {
    		$_SESSION['SESSION_START_TIME'] = time();
		} 
		// session started more than 30 minutes ago
		else if (time() - $_SESSION['SESSION_START_TIME'] > 1800) {
    		// don't want to restart session because that deletes all info
    		// in it. Just want to give a new ID and update the creation time
    		session_regenerate_id(true);
    		// session_regenerate_id(false);
    		$_SESSION['SESSION_START_TIME'] = time();
    		return false;
		}
		return true;
	}

	/**
	* if session is obsolete, redirect to login page
	*/
	public static function is_session_good(){
		// test
		switch (session_status()) {
		 	case '0':
		 		echo "(SM)session disabled<br />";
		 		return false;
		 		break;
		 	
		 	case '1':
		 		echo "(SM)no session<br />";
		 		return false;
		 		break;

		 	case '2':
		 		echo "(SM)session active<br />";
		 		break;

		 	default:
		 		echo "(SM)problem checking session<br />";
		 		break;
		}

		if(!self::is_user_logged_in()){
			echo "(SM) not logged in!";
			return false;
		}
		
		if(self::is_session_obsolete()){
			echo "(SM) session obsolete!";
			return false;
		}
		
		else {
			// clear session
			//self::restart_session();
			//self::end_session();
		?>
			<script type="text/javascript">
				//alert("You have been logged out due to obsolete session. Please reauthenticate");
				//window.location.href='/login';
			</script>
		<?php
			exit();
		}
	}

	/**
	*
	*/
	public static function is_user_logged_in(){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 0){
			return true;
		}
		return false;
	}

	/**
	*
	*/
	public static function is_session_obsolete(){
		return (isset($_SESSION['IS_OBSOLETE']) && $_SESSION['IS_OBSOLETE'] === 1);
	}

	/**
	*
	*/
	public static function is_session_locked(){
		return (isset($_SESSION['IS_LOCKED']) && $_SESSION['IS_LOCKED'] === 1);
	}	

}
?>
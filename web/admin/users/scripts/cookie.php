<?php
/**
* @author Daniel Personius
* @category Sessions and Cookies
* @uses AuthException.php
* @version 1.0
* @todo remember me, new custom exceptions, create auto_login db table
*/

include("AuthException.php");


class Cookie{

	/**
	*
	*/
	private $created;

	/**
	*
	*/
	private $user_id = "";

	/**
	*
	*/
	private $version;

	/**
	* mcrypt handle
	*/
	private $td;


	/**
	* mcrypt info:
	*/
	static $cypher = 'blowfish';
	static $mode   = 'cfb';
	static $key    = 'choose a better key';


	/**
	*
	*/
	# cookie format info:
	static $cookie_name = "USERAUTH";
	static $my_version  = '1';
	# when to expire the cookie:
	static $expiration = '600'; # 10 minutes
	# when to reissue the cookie:
	static $warning = '300'; # 5 minutes
	static $glue = '|';

	# Remember me info: 
	
	/**
	* @var string $selector		used for database lookups
	* @access public
	*/
	public $selector;

	/**
	* @var string $validator	used to authenticate user automatically
	* @access public
	*/
	public $validator;

	/**
	* @var string $hashed_validator		sha-256 hashed version of validator for storage 
	*/
	public $hashed_validator;

	/**
	*
	*/
	public function __construct($user_id = false){
		# $this->td = mcrypt_module_open('blowfish', '', 'cfb', '');
		if($user_id){
			$this->user_id = $user_id;
			return;
		}
		else {
			if(array_key_exists(self::$cookie_name, $_COOKIE)){
				$buffer = $this->_unpackage($_COOKIE[self::$cookie_name]);
			}
			else {
				throw new AuthException("No Cookie!");
			}
		}
	}


	/**
	*
	*/
	public function set(){
		$cookie = $this->_package();
		#echo "<br />cookie packaged!";
		# don't need to set expiration time, indicating that the browser should discard the cookie automatically when it is shut down: 
		setcookie(self::$cookie_name, $cookie, self::$expiration, '/', 0, 0);
	}
	/**
	* assembles, encrypts, and sets cookie
	* @param int 	$user_id			user id used for database lookups(default: user id associated with current cookie object)
	* @param string $selector			selector used for database lookups(default: selector associated with current cookie object)
	* @param string $hashed_validator	encrypted(default: hashed validator associated with current object) 
	*/
	# $user_id = $this->user_id, $selector = $this->selector, $hashed_validator = $this->hashed_validator
	public function set_remember_me_cookie($user_id, $selector, $hashed_validator){
		if(!empty($selector) && !empty($validator)){
			$remember_me_cookie = $this->_package();

			# $d = new DateTime( '2010-01-31' );
			#$d = date("l j F Y"); # day of week, day of month, month, year
			# if day of the month is 30 or 31 or date is february 29 on a leap year, date to expire is last day of next month
			# Otherwise, date to expire is current day number next month
			$date_to_expire = (date("j") === "30" || date("j") === "31" || (date("m L") === "02 1" && date("j") === "29")) ? "last day of +1 month": "+1 month";
			# may change httponly(last 0) to 1: 
			setcookie("Remember Me", $remember_me_cookie, strtotime($date_to_expire), '/', 0, 0);
		}

		$cookie = $this->_package();
		#echo "<br />cookie packaged!";
		# don't need to set expiration time, indicating that the browser should discard the cookie automatically when it is shut down: 
		setcookie(self::$cookie_name, $cookie, self::$expiration, '/', 0, 0);
	}

	/**
	* checks the structure of the cookie and verifies that it is the correct version and is not stale. Also handles resetting the cookie if it is getting close to expiration
	*/
	public function validate(){
		if(!$this->version || !$this->created || !$this->user_id){
			throw new AuthException("Malformed cookie");
		}
		if($this->version != self::$my_version){
			throw new AuthException("Version mismatch");
		}
		if(time() - $this->created > self::$expiration){
			throw new AuthException("Cookie expired");
		} else if(time() - $this->created > self::$resettime) {
			$this->set();
		}
	}

	/**
	* called if 'remember me' selected
	* generate 2 random strings: selector, validator, hash validator with SHA-256, store selector and validator hash in db, store selector and validator in cookie
	* @param int user id
	* @return bool true if selector and hashed validator stored | false if any error along the way 
	*/
	# $user_id = $this->user_id
	public function generate_remember_me_tokens($user_id){
		# generate random strings: 
		$this->selector  = bin2hex(random_bytes(64));
		$this->validator = bin2hex(random_bytes(64));
		# hash validator: 
		$this->hashed_validator = hash('sha256', $validator);

		# store: (may move to separate function)
		require("local_mysqli_connect.php");
		if($stmt = $conn->prepare("INSERT INTO auto_login(user_id, selector, hashed_validator) VALUES (?, ?, ?)")){
			$stmt->bind_param('iss', $user_id, $this->selector, $this->hashed_validator);
			if(!$stmt->execute()){
				throw new AuthException("Could not execute query!");
				return false;
			}
			else{
				$result = $stmt->get_result();
				if($result->affected_rows === 0){
					throw new AuthException("Could not store data!");
					return false;
				}
				$result->free();
				$stmt->close();
			}

		}
		else {
			throw new AuthException("Failure to store remember me tokens!");
			return false;
		}
		$conn->close();
		return true;
	}

	/**
	*
	*/
	public function redeem_remember_me_tokens(){
		include("input_sanitation.php");
		# array to store tokens in 
		$tokens = array();
		$clean_tokens = array();

		# split incoming cookie into selector, validator: 
		$tokens = explode(",", $_COOKIE["Remember Me"]);

		# sanitize for query: 
		foreach ($tokens as $key => $value) {
			array_push($clean_tokens, clean_data($tokens[$key]));
		}

		# db lookup based on selector: 
		include("local_mysqli_connect.php");
		if($stmt = $conn->prepare("SELECT * FROM auth_login WHERE selector=?")){
			$stmt->bind_param('s', $clean_tokens["selector"]);
			if(!$stmt->execute()){
				# throw error...
				# test
				echo "<br />Could not execute query!";
			}
			$result = $stmt->get_result();

			# if row found, hash COOKIE validator:
			# may change num rows to === 1 --> research
			if($result->num_rows > 0){
				# may need to change to $clean_tokens['validator']: 
				$hashed_cookie_validator = hash('sha256', $tokens['validator']);
			}

			# compare hashed cookie validator to hashed db validator
			if(hash_equals($row['hashed_validator'], $hashed_cookie_validator)){
				# if compare true, log in user: 
				# include("Authentication.php");
				# _login();
			}
		}
	}

	/**
	* sets cookie to empty value with expiration time of 0 - 7pm Dec 31, 1969 as a UNIX timestamp
	*/
	public function logout(){
		# set_cookie(self::$cookie_name, "", 0);
		# setcookie(self::$cookie_name, "", time() - 42000);
	}

	/**
	*
	*/
	private function _package(){
		# Test:
		# echo "<br /><br />_package(): ";
		$parts = array(self::$my_version, time(), $this->user_id);
		#test:
		# echo "<br />parts: ";
		# print_r($parts);
		# echo "<br />glue: " . self::$glue;
		# turn array of required info into a string:
		$cookie = implode(self::$glue, $parts);
		# echo "<br />cookie: $cookie";
		# return $this->_encrypt($cookie);
		return $cookie;
	}

	/**
	*
	*/
	private function _unpackage($cookie){
		# $buffer = $this->_decrypt($cookie);
		# turn string of required info into an array: 
		list($this->version, $this->created, $this->user_id) = explode($glue, $buffer);
		if($this->version != self::$my_version || !$this->created || !$this->user_id){
			throw new AuthException();
		}
	}

	/**
	* encrypts a plain-text string by using cypher specifiec in class attributes
	* @param string plain text string
	
	private function _encrypt($plain_text){
		# create the initial vector or seed
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		# prepend iv to encrypted string
		mcrypt_generic_init($this->td, $this->key, $iv);
		$crypt_text = mcrypt_generic($this->td, $plain_text);
		mcrypt_generic_deinit($this->td);
		return $iv . $crypt_text;

		return hash('sha256', $plain_text);
	}
	*/

	private function _encrypt($plain_text){

		return $crypt_text;
	}
	/**
	* decrypts an encrypted string and returns it
	* @param string encrypted text
	
	private function _decrypt($crypt_text){
		$iv_size = mcrypt_get_iv_size($this->td);
		$iv = substr($crypt_text, 0, $iv_size);
		$crypt_text = substr($crypt_text, $iv_size);
		mcrypt_generic_init($this->td, $this->key, $iv);
		$plain_text = mdecrypt_generic($this->td, $crypt_text);
		mcrypt_generic_deinit($this->td);
		return $plain_text;
	}
	*/
	/**
	*
	*/
	private function _reissue(){
		$this->created = time();
	}
}
?>
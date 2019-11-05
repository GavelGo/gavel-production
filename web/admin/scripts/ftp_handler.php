<?php
/**
* ftp_handler.php
* 
* this may not be necessary, but also may be useful for setting up non-web-based
* CRUD applications in the future, e.g. running automated scripts modifying employee information
* or content moderation or something
*/






/**
* define custom exception class to handle ftp errors
*/
class FtpException extends Exception {
	// 
	private $previous;
	// 
	private $log_handle;
	
	/**
	* redefine to make message not optional 
	*/
	public function __construct($message, $code = 0, Exception $previous = null){
		parent::__construct($message, $code, $previous);
		// get previous exception
		if(!is_null($previous)){
			$this->previous = $previous;
		}
		// open log file to write
		$this->log_handle = fopen($log_file_name, "w");
	}

	/**
	*
	*/
	public function get_previous(){
		return $this->previous();
	}

	/**
	* string representation
	*/
	public function __toString(){
		return __CLASS__ . ": {$this->message}(code: [{$this->code}])\n";
	}
}

/**
* ftp operations for remote login to admin portal
* @todo add spaghetti for ssl connection or fully replace non-ssl code with ssl
*/

// require elements/file_upload

class ftp_handler{
	// 
	private $server      = "";
	// 
	private $conn_id 	 = null;
	// 
	private $ssl_conn_id = null;
	// 
	private $login 		 = null;
	// 
	private $username 	 = "";

	/**
	* may move some of this to admin config file
	*/
	public function __construct(){
		$this->server = "";
		try {
			$this->ftp_conn = ftp_connect($this->server);
			// ssl connection
			$this->ssl_conn_id = ftp_ssl_connect($this->server); 

			// $password = get_password()
			//$this->login = ftp_login($this->ftp_conn, $username, $password);
		}
		catch(FtpException $e){
			// ...
		}
	}

	/**
	* upload a file
	* @param basename - the base name of the file
	*/
	public function upload_file($basename, $local_basename, $dir = '', $mode = "FTP_ASCII"){
		// checks
		// authority
		// file size <= max allowed 
		// secure connection? 
		try {
			// allocate space
			ftp_alloc($conn_id, filesize($basename), $result);
			// change directory, if on specified
			if(!empty($dir)){
				ftp_chdir($conn_id, $dir);
			}
			// send file
			ftp_put($conn_id, $basename, $local_basename, $mode);
		}
		catch(FtpException $e){
			// ...
		}
	}

	/**
	*
	*/
	public function delete_file($basename){
		// some checks, auth, etc.
		// file exists
		// caller has authority
		// !file exists afterward

		// delete file
		ftp_delete($conn_id, $basename);
	}

	/**
	*
	*/
	public function get_file($basename, $local_basename){
		// checks
		// file exists
		// caller auth
		// file size <= max allowed

		// open local file to write to
		$local_file = fopen($local_basename, "w");
		// get file
		try {
			ftp_fget($this->conn_id, $local_file, $basename, FTP_ASCII, 0);
			// echo response 
		}
		catch(FtpException $e){
			// ...
		}
	}

	/**
	*
	*/
	public function get_list($dir = "."){
		// checks
		$file_list = ftp_nlist($conn_id, $dir);
		// test
		var_dump($file_list);
		// end test
	}

	/**
	*
	*/
	public function create_directory($name){
		// checks
		try{
			ftp_mkdir($conn_id, $name);
		}
		catch(FtpConnection $e){

		}
	}

	/**
	*
	*/
	public function get_time_last_modified($basename){
		return ftp_mdtm($conn_id, $basename);
	}

	/**
	*
	*/
	public function execute_command($command){
		try{
			ftp_exec($conn_id, $command);
		}
		catch(FtpException $e){
			// user message
		}
	}

	/**
	*
	*/
	public function explain_error(){
		// maybe like a switch case returning a string trying to offer help?
		// or maybe if error, redirect to error page, offering help?
	}

	/**
	*
	*/
	public function get_options($option){
		return ftp_get_option($this->conn_id, $option);
	}

	/**
	*
	*/
	public function close_handle(){
		ftp_close($conn_id);
	}

}
?>
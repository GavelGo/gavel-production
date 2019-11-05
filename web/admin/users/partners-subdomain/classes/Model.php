<?php
namespace PartnerDomain;
use Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

/**
* the parent model for all business objects
*/
abstract class Model {
	/**
	* @var database handle
	*/	
	protected static $dbh;

	/**
	* @var logging handle
	*/
	protected static $logger;

	/**
	* @var database statement
	*/
	protected $stmt;

	public function __construct($channelName, $errorDomain){
		$this->set_dbh();
		$this->set_logger($channelName, $errorDomain);
	}


	/**
	* @todo fix dep injection
	*/
	protected static function set_dbh(){
		self::$dbh = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno(self::$dbh)) {
			// user friendly message
			// notify admin
			// log error
			self::set_logger('Model', 'MYSQL');
			self::$logger->error('could not set database handle: ' . self::$dbh->error);
		}
	}

	/**
	* @param errorDomain - php, mysql, or apache
	*/
	private static function set_logger($channelName, $errorDomain) {
		self::$logger = new Logger($channelName);

		$logfile = null;
		switch (strtolower($errorDomain)) {
			case 'php':
				$logfile = constant("PHP_LOG");
				break;
			
			case 'mysql':
				$logfile = constant("MYSQL_LOG");
				break;

			case 'apache':
				$logfile = constant("APACHE_LOG");
				break;

			default:
				break;
		}
		self::$logger->pushHandler(new StreamHandler($logfile), Logger::DEBUG);
	}

	/**
	* provide access to db handle
	*/
	public static function give_dbh(){
		if(is_null(self::$dbh)){
			self::set_dbh();
		}
		return self::$dbh;
	}

	/**
	*
	*/
	public static function give_logger($channelName, $errorDomain) {
		if(is_null(self::$logger)){
			self::set_logger($channelName, $errorDomain);
		}
		return self::$logger;
	}

	/**
	* make names and titles url-friendly
	*/
	public static function encode_name($realName){
		$urlName = implode("-", explode(" ", strtolower($realName)));
		return $urlName;
	}

	public static function encodeUrl(string $param) : string {
		return urlencode(base64_encode($param));
	}

	public static function decodeUrl(string $hash) : string {
		return Sanitation::clean_data(base64_decode(urldecode($hash)));
	}

	/**
	* convert url-friendly names and titles to real names and titles
	* @param string name
	*/
	public static function decode_name($urlName){
		$realName = implode(" ", explode("-", strtolower($urlName)));
		return $realName;
	}

	/**
	* convert a mysql timstamp to formatted datetime
	*
	* @param timestamp - string: mysql timestamp
	*
	* @return string - day of month month, year HH::MM::SS
	*/
	public static function getDateTime(string $timestamp) {
		return date('F j Y g:i A', strtotime($timestamp));
	}

	/**
	* generic prepared select statement
	*/
	public static function selectPrepared($query, $columnTypes, ...$values) {
		$queryResults = null;

		$dbHandle = self::give_dbh();
		// debug_backtrace traces the call to this enclosing function, then 'file' gets the filename
		// pathinfo()['filename'] is like basenmae() but trims the file extension '.php'
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[0];
		$filename = pathinfo($backtrace['file'])['filename'];
		$line = $backtrace['line'];
		$loggerHandle = self::give_logger($filename, 'mysql');
		
		if ($stmt = $dbHandle->prepare($query)) {
			$stmt->bind_param($columnTypes, ...$values);
			if ($stmt->execute()) {
				$result = $stmt->get_result();
				while($row = $result->fetch_assoc()){
					$queryResults[] = $row;
				}
			}
			else {
				// set user message
				$loggerHandle->error("line " . $line . ": " . $dbHandle->error);
			}
		}
		else {
			// set user message
			$loggerHandle->error("line " . $line . ": " . $dbHandle->error);
		}

		return $queryResults;
	}

	/**
	* generic non-prepared select statement
	*/
	public static function select($query) {
		$queryResults = null;

		$dbh = self::give_dbh();
		// debug_backtrace traces the call to this enclosing function, then 'file' gets the filename
		// pathinfo()['filename'] is like basenmae() but trims the file extension '.php'
		$logger = self::give_logger(pathinfo(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[0]['file'])['filename'], 'mysql');

		if ($stmt = $dbh->query($query)) {
			while($row = $stmt->fetch_assoc()) {
				$queryResults[] = $row;
			}
		}
		else {
			// set user message
			$logger->error($dbh->error);
		}
		return $queryResults;
	}

	/**
	* insert, update, or delete
	* @param giveId - boolean, if true, return insert id as well
	*/
	public static function affectRowsPrepared($query, $columnTypes, ...$values) {
		$affectedRows = -1;

		$dbh = self::give_dbh();
		// debug_backtrace traces the call to this enclosing function, then 'file' gets the filename
		// pathinfo()['filename'] is like basenmae() but trims the file extension '.php'
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[0];
		$filename = pathinfo($backtrace['file'])['filename'];
		$line = $backtrace['line'];
		$logger = self::give_logger($filename, 'mysql');

		if ($stmt = $dbh->prepare($query)) {
			$stmt->bind_param($columnTypes, ...$values);
			if ($stmt->execute()) {
				$affectedRows = $stmt->affected_rows;
			}
			else {
				// set user message
				$logger->error("line " . $line . ": " . $dbh->error);
			}
		}
		else {
			// set user message
			$logger->error("line " . $line . ": " . $dbh->error);
		}

		return array(
			'affected_rows' => $affectedRows,
			'insert_id'     => self::get_last_insert_id()
		);
	}

	/**
	*
	*/
	public static function get_last_insert_id(){
		return self::$dbh->insert_id;
	}
}
?>
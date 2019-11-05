<?php
use PartnerDomain\Model;
use PartnerDomain\Messages;
/**
* 
* @todo Roles 
*/
class Authentication extends Model
{
	/**
	* @param string email
	* @param string password
	* @return int user id
	*/
	public static function check_user_credentials($email, $password)
	{
		$dbh = Model::give_dbh();
		$user_id = 0;
		if ($stmt = self::$dbh->prepare("SELECT user_id, user_email, user_password_hash FROM users WHERE user_email=?")) {
			$stmt->bind_param('s', $email);
			if (!$stmt->execute()) {
				// todo - format
				echo "<br />Could not log in. Please try again.";

			}
			$result = $stmt->get_result();

			# check if user existss
			if ($result->num_rows === 0) {
				Messages::set_message("No User Found!", 'error');
			}
			else if ($result->num_rows === 1) {
				# loop through results
				while ($row = $result->fetch_assoc()) {
    				if (password_verify($password, $row['user_password_hash'])) {
    					$user_id = $row['user_id'];
    				}
    				else {
    					Messages::set_message("Incorrect Login", 'error');
    				}
				}
			}
		}
		return $user_id;
	}

	/**
	* login functionality
	* @todo maybe move to separate file or to user system class/structure 
	* @param array $row    array of user info from db | default: empty array
	* @return true login successfuly | false login unsuccessful
	*/
	public static function _login($row = array())
	{
		if (!empty($row)) {
			# loop through array elements, assigning each to seesion variable of same name: 
			foreach ($row as $key => $value) {
    			$_SESSION[$key] = $value;
    			# test
    			print_r($_SESSION);
    		}
    		return true;
		}
		else {

		}
	}

	/**
	*
	*/
	public static function get_user()
	{
		$user = new UserModel();
		# $user->get_by_name();
	}

	/**
	* @param int user id, string username, string hashed password 
	* @assumes hashed password parameter
	*/
	public static function check_password($id = 0, $password)
	{
		$status = 0;
		$user = new UserModel(array(
			'user_id' => $id
		));
		$dbh = Model::give_dbh();
		if ($stmt = $dbh->prepare("SELECT user_password_hash FROM users WHERE user_id=?")){
			# send values: 
			$stmt->bind_param('i', $id);
			# perform query: 
			$stmt->execute();
			# # result will become var db_pass:
			$stmt->bind_result($db_pass);
			# get result: 
			$stmt->fetch();
			# verify given password against stored password: 
			$status = (password_verify($password, $db_pass))? 1: 0;
		}
		return $status;
	}
}
?>

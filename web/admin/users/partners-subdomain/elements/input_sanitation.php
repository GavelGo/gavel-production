<?php

/**
*
*/
class Sanitation{
/**
*
*/
function clean_data($data, $encoding='UTF-8'){
	# check type:
	/*
	if(is_numeric($data)){
		# Test:
		$min = 1;
		$max = 100;
		if (filter_var($data, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
    		echo("Variable value is not within the legal range");
			$data =  0;
		}
		else {
			return (int)$data;
		}
	}
	*/
	
	# else {
		# trim — Strip whitespace (or other characters) from the beginning and end of a string: 
		$data = trim($data);
		# stripslashes — Un-quotes a quoted string:
		$data = stripslashes($data);
		$data = str_replace('"', '', $data);
		$data = strip_tags($data);
		$data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
		# converts characters to HTML entities
		#$data = htmlentities($data, ENT_NOQUOTES, $encoding);
	# }
	return $data;
}

/**
* @param string email address
* @return bool validation success
*/
function validate_email($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
*
*/
function sanitize_string($str){
	#return clean_data(filter_var($str, FILTER_SANITIZE_STRING));
	$clean_str = preg_replace("/[^ \w]+/", "", $str);
	return $clean_str;
}

/**
*

function encrypt_password($password){
	# password_hash — Creates a password hash using one-way hashing algorithm
	# string password_hash ( string $password , integer $algo [, array $options ] )
	# default alg current BCRYPT, a 60 char result
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	return $hashed_password;
}
*/
/**
* clean filename, verify that it does not backtrack out of current directory
* @var string filename
*/
function less_expensive_clean_file_name($file_name){
	if(substr($file_name, 0, 1) == "/" || strstr){
		
	}
}

/**
* stricter but more expensive check:
* @var string filename
*/
function expensive_clean_file_name($filename){
	# $file_name = realpath($_GET['filename']);
	$clean_path = realpath("./");
	if(!strncmp($file_name, $clean_path, strlen($clean_path))){
		# file is bad
	}
}

/**
*
*/
function echo_clean($data){
	echo clean_data($data);
}
}

?>
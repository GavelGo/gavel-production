<?php
class Messages
{
	# PROPERTIES
	# Error Messages

	/**
	* @var array 	collection of all error message titles for custom error pages 
	*/
	public static $error_message_headers = array(
	'page_not_existant' => 'The page you requested could does not exist.',
	'page_not_found'    => 'We\'re sorry, we cannot retrieve the request page at this time. Please try again later or contact us for more information.',
	'connection_failed' => 'We\'re sorry, we could not connect you to the requested resource at this time. Please check your connection or try again later.',
	'resource_not_found' => 'The information you requested does not exist.'
	# etc... add more with functions through GUI
	);

	/**
	* collection of all error additional info and explanations for custom error pages
	*/
	public static $error_message_bodies = array(

		);

	/**
	* collection of all error footers - what to do now info for custom error pages
	*/
	public static $error_message_footers = array(

		);

	/**
	*
	*/
	public static function set_message($text = '', $type = 'success')
	{
		if ($type === 'error') {
			$_SESSION['error_message'] = $text;
		}
		else if ($type === 'success') {
			$_SESSION['success_message'] = $text;	
		}
	}

	/**
	*
	*/
	public static function display()
	{
		if (isset($_SESSION['error_message'])) {
			echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
			unset($_SESSION['error_message']);
		}
		if (isset($_SESSION['success_message'])) {
			echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
			unset($_SESSION['success_message']);
		}
	}

	/**
	*
	*/
	public static function add_error_message_header($key = '', $message = '')
	{
		if (!is_null($key) && !is_null($message) && !array_key_exists($key, $error_message_headers)) {
			$error_message_headers[$key] = $message;
		}
	}
}
?>
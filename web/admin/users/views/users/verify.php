<?php
# session_start();
/**
* user account verification View
* @author Daniel Personius
* @startdate June 10, 2017
*/

#if(!empty($_GET['register']) && $_GET['register'] == "success"){
if(isset($_SESSION['user_email']) && $_SESSION['IS_OBSOLETE'] !== 1 && $_SESSION['IS_LOCKED'] !== 1){ }

if(isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === 1){
	# test:
	# echo "<br />pass: " . $_SESSION['hashed_password'];
	echo "<br />Thank you for registering! Please verify your account by following the link emailed to you at " . $_SESSION['user_email'] . ".";
	
	$url = CUST_ROOT_URL . 'users/activate/' . $_SESSION['activation_token'];
	$footer = "Bidpuppy International, Inc     Copyright 2017";

	# $to = $email;
	$subject = "Gavelgo Registration Verification";
	$message = '

	Thanks for signing up!
	Please follow this link to activate your account: $url
	This link expires in 24 hours.

	--
	$footer

	';
	$header = "From: no-reply@gavelgo.com \r\n"; #  Reply-To: no-reply@gavelgo.com \r\n
  	# add conditional
  	# $form_content = "From: customerservice@gavelgo.com";

	# send email:
	mail($_SESSION['user_email'], "Gavelgo | Activate your account", $message, $header);
} 
?>
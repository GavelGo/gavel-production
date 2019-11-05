<!DOCTYPE html>
<html>
<head>
	<title>Account</title>

	<script type="text/javascript">
		function sendPasswordResetEmail(){
		}
	</script>
</head>
<body>
<?php
if(!is_null($view_model)){
?>
	<h1>ACCOUNT SETTINGS</h1>
	<h3>UPDATE</h3>
	<form action="" method="POST" id="accountUpdateForm">
		<label for="account_admin">Account Administrator</label>
		<br />
		<input type="text" name="account_admin" value="<?php echo $view_model->account_admin;?>" />
		<br /><br />
		<label for="account_email">Email</label>
		<br />
		<input type="text" name="account_email" value="<?php echo $view_model->account_email;?>" />
		<br /><br />
		<label for="account_phone">Phone Number</label>
		<br />
		<input type="text" name="account_phone" value="<?php echo $view_model->account_phone;?>">
		<br /><br />
		<input type="submit" name="submit_update" value="Update"/>
	</form>
	<br /><br />
	<button onclick="sendPasswordResetEmail()">Send password reset email</button>
	<br /><br />
	<button>Delete Account</button>
	<br /><br />
	<form action="" method="POST" id="deleteAccountForm">
		<input type="submit" name="submit_delete" value="Delete Acct">
	</form>
<?php
}
?>
</body>
</html>
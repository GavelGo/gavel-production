<?php
echo realpath("users/partners-subdomain/assets/js/textCounter.js");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Partner</title>
	<script src="users/partners-subdomain/assets/js/validation.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
	function countChars(textarea, span, limit){
		document.getElementById(span).innerHTML = document.getElementById(textarea).value.length + "/" + limit;
	} 
</script>

</head>
<body>
<h1>ADD PARTNER</h1>
<form action="" method="POST" id="addPartnerForm">
	<label for="provider_name">Company Name(*)</label>
	<br />
		<input type="text" name="provider_name" maxlength="100" required="required" />
	<br />
	<label for="provider_description">Description(*)</label>
	<br />
		<textarea rows="5" cols="19" name="provider_description" id="pd" maxlength="255" required="required" onkeyup="countChars('pd', 'remainingCharacters', 255)" placeholder="A short bio or additional information..."></textarea>
		<span id="remainingCharacters"> /255</span>
	<br />
	<label for="provider_category_id">Category(*)</label>
	<br />
		<select required="required" name="provider_category_id" size="1">
		<option disabled="disabled" selected value>-- Select a Category --</option>
<?php
		$categories = CategoryModel::get_names();
  		if(!is_null($categories)){
  			foreach ($categories as $key => $value) {
  				echo '<option value="' . $key . '">' . $value . '</option>';
  			}
    	}
?>	
		</select>
	<br />
	<label for="provider_website">Website(*)</label>
	<br />
	<input type="text" maxlength="100" name="provider_website" value="www." />
	<br />
	<label for="provider_public_email">Public Email</label>
	<br />
	<input type="text" maxlength="100" name="provider_public_email" />
	<br />
	<label for="provider_public_phone">Public Phone</label>
	<br />
	<input type="text" name="provider_public_phone" maxlength="10" size="10" />
	<br />
	<label for="provider_address_line_one">Address Line One(*)</label>
	<br />
	<input type="text" name="provider_address_line_one" maxlength="100" required="required" />
	<br />
	<label for="provider_address_line_two">Address Line Two</label>
	<br />
	<input type="text" name="provider_address_line_two" maxlength="100" />
	<br />
	<label for="account_admin">Primary Account Administrator(*)</label>
	<br />
	<input type="text" name="account_admin" maxlength="100" required="required" />
	<br />
	<label for="account_email">Administrator Email(*)</label>
	<br />
	<input type="text" name="account_email" maxlength="100" required="required" />
	<br />
	<label for="account_phone">Administrator Phone</label>
	<br />
	<input type="text" name="account_phone" maxlength="10" />
	<br />

	<br /><br />
	<input type="submit" name="add_provider" value="Add">
</form>
</body>
</html>
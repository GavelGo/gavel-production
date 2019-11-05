<?php
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['partner_id'])){
}
else {
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script type="text/javascript">
	
	/*
	$("#updateProfileForm").submit(function(event) {

      // stop form from submitting normally
      event.preventDefault();

      //get the action attribute from the <form action=""> element
      var $form = $( this ),
          url = $form.attr( 'action' );

      // Send the data using post with element id name and name2
      var posting = $.post( url, { name: $('#name').val(), name2: $('#name2').val() } );

      // Alerts the results
      posting.done(function( data ) {
        alert('success');
      });
    });
	*/
    /*
	function updateProfile(){
		// update profile ajax call
		//alert("TEST");
		$(document).ready(function(){
    		$("#updateProfile").click(function(){
        		$.ajax({
            		type: "POST",
            		url: "/partner_handler.php",
            		data: {
            			partner_id: "<?php #echo $_SESSION['partner_id']?>",
        				request: "update_profile"},
            		success: function(response) {
                 		alert(response);
                 		//document.getElementById("test").innerHTML = "After ajax call";
            		}
       		 	});
    		});
    	});
	}
	*/
		$(document).ready(function(){
			// request category change ajax call
    		$("#requestCategoryChange").click(function(){
        		$.ajax({
            		type: "POST",
            		url: "/partner_handler.php",
            		data: {
            			partner_id: "<?php echo $_SESSION['partner_id']?>",
        				request: "category_change"},
            		success: function(response) {
                 		alert("response: " + response);
            		}
       		 	});
    		});

    		// update profile ajax call
    		$("#updateProfile").click(function(){
        		$.ajax({
            		type: "POST",
            		url: "/partner_handler.php",
            		data: {
            			partner_id: "<?php echo $_SESSION['partner_id']?>",
        				request: "update_profile"
        			},
        				// data: get form data
            		success: function(response) {
                 		location.reload();
                 		alert(response);
            		}
       		 	});
    		});

    		$(".deleteButtons").click(function(){
    			alert("delete post " + $(this).attr('id') + "?");
    			// ajax call to partner handler to delete post
    			$.ajax({
    				type: "POST",
    				url: "/partner_handler.php",
    				data: 
    				{
    					partner_id: "<?php echo $_SESSION['partner_id']?>", 
    					post_id: $(this).attr('id'),
    					request: "delete_post"
    				}, 
    				success: function(response) {
    					alert(response);
    				}
    			});
    		});
		});
	</script>

<style type="text/css">
	body {
			/* background-image: url(<?php #echo "../../assets/img/uploads/providers/" . $request_data->photo_basename?>);
			background-repeat: no-repeat;
			background-size: cover; */
	}
</style>
</head>
<body>
<?php
Messages::display();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1 && isset($_SESSION['partner_id'])){
?>
	<h1>EDIT PROFILE</h1>
	<h3><a href="/profile">View Profile</a></h3>
	<form enctype="multipart/form-data" action="" method="POST" id="updateProfileForm">
		<label for="provider_email">Email</label>
		<br />
		<input type="text" name="provider_public_email" id="provider_email" size="25" value="<?php echo $request_data->public_email?>" />
		<br /><br />
		<label for="provider_public_phone">Phone Number</label>
		<br />
		<input type="text" name="provider_public_phone" size="10" id="provider_public_phone" value="<?php echo $request_data->public_phone?>" />
		<br /><br />
		<label for="provider_description">Description</label>
		<br />
		<textarea id="provider_description" name="provider_description" rows="5" cols="20" maxlength="255"><?php echo $request_data->description?></textarea>
		<br /><br />
		<label for="provider_website">Website</label>
		<br />
		<input type="text" name="provider_website" id="provider_website" value="<?php echo $request_data->website?>" />
		<br /><br />
		<label for="provider_address_line_one">Address Line One</label>
		<br />
		<input type="text" name="provider_address_line_one" size="20" id="provider_address_line_one" value="<?php echo $request_data->address_line_one?>" />
		<br /><br />
		<label for="provider_address_line_two">Address Line Two</label>
		<br />
		<input type="text" name="provider_address_line_two" size="20" id="provider_address_line_two" value="<?php echo $request_data->address_line_two?>" />
		<br /><br />
		<label for="provider_photo">Profile Picture</label>
		<br />

		<!-- display current profile picture: -->
		<img src="../../assets/img/uploads/providers/<?php echo $request_data->photo_basename;?>" alt="provider profile picture" style="width:200px;height:200px;">

		<br />
		<input type="file" name="provider_photo">
		<br /><br />
		<input type="submit" name="submit_update" value="Update" />
	</form>
	
	<button id="requestCategoryChange">Request a category change</button>
	<br />

	<h1><br />FEED</h1>
<?php
	$posts = $request_data->get_posts();
	foreach ($posts as $key => $value) {
		echo "<p><b>" . $value["post"] . "</b></p>";
		echo "<p>" . date('F d, Y', strtotime($value["time_submitted"])) . "</p>";
?>
		<!-- onPress ajax call to delete -->
		<input type="button" id='<?php echo $value['post_id']?>' class="deleteButtons" name="Delete" value="Delete">
		<br /><br /><br />
<?php
	}
}
else {
}
?>
</body>
</html>
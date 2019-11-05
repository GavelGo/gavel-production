<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Auction Profile</title>
<style type="text/css">
	
</style>
<script>
	/*
	function showRespondForm(){
		// change button text: 
		if(document.getElementById("respondButton").innerHTML === "Respond"){
			document.getElementById("respondButton").innerHTML = "Close";
		}
		else {
			document.getElementById("respondButton").innerHTML = "Respond";
		}
		// show or hide form depending on button text: 
		if(document.getElementById("respondForm").style.display=== "none"){
			document.getElementById("respondForm").style.display="block";
		}
		else {
			document.getElementById("respondForm").style.display="none";
		}
	}

	// ajax call to send response
	function respondToBid(){

	}
	*/

	$(document).ready(function(){
		// show response form
		// TODO: change button value on click
		$("#leaveResponseButton").click(function(){
			// Test:
			//alert("asdfasd");
			if($("#leaveResponseForm").is(":visible")){
				$("#leaveResponseForm").hide();
				// Untested: 
				//$("#leaveResponseButton").text("Respond");
			} else {
				$("#leaveResponseForm").show();
				//$("#leaveResponseButton").text("Cancel");
			}
			return false;
		});

		// submit response and add to list of responses shown on page: 
		$("#submitResponseButton").click(function(){
			$.ajax({
				type: "POST",
				url: "/auction_handler.php",
				data: {
					provider_name: "<?php echo $_SESSION['partner_name']?>",
					//user_id: "<?php #echo $request_data->user_id?>",
					auction_id: "<?php echo $request_data->id?>",
					response_comment: $("#responseComments").val(),
					response_offer: $("$responseOffer").val(),
					request: "leave_response"
				},
				success: function(jsonData){
					// Test:
					alert(jsonData);
					/*
					parsedJson = jSON.parse(jsonData);
					if(parsedJson['result'] !== "success"){
						alert("Could not submit response due to server error. Please contact us regarding this issue.");
					}
					else if(parsedJson['result'] === 'success'){
						alert("Response submitted!");
						$("#responsesDiv").prepend('<p><b>' + parsedJson['provider_name'] + '</b> on <?php #echo date('F d, Y'); ?></p><p>' + parsedJson['offer'] + '</p><p>' + parsedJson['comment'] + '</p><br /><br />');
					}
					else {
						alert("Stuck on pending!");
					}
					*/
				},
				error: function(status){
					alert("Error submitting response");
				}
			});
			return false;
		});
	});
</script>
</head>
<body>
<?php
Messages::display();
if(!is_null($request_data)){
	# view model is array if on user's auctions pages: 
	if(is_array($request_data)){

	}
	# else, on a singular auction page: 
	else {
		echo "<h2>Auction '<b>" . $request_data->title . "</b>' by User <b>" . $request_data->user_name . "</b></h2>";
		echo "<p>TODO: print out rest of info formatted</p>";
	}
}
?>
<button id="leaveResponseButton">Respond</button>

<br /><br />
<form action="" method="POST" id="leaveResponseForm" style="display: none">
	<label for="offer">Offer</label>
	<br />
	$<input type="text" size="6" name="offer" id="responseOffer" required="required">
	<br />
	<label for="comments">Comments</label>
	<br />
	<textarea rows="5" cols="20" id="responseComments" placeholder="write your comments here..."></textarea>
	<br />
	<input type="button" id="submitResponseButton" name="submitResponse" value="Send" />
</form>

<h3>Responses</h3>
<div id="responsesDiv">
<?php
	$responses = $request_data->get_responses();
	if(!empty($responses)){
		foreach($responses as &$r){
?>
		<p><b><?php echo $r['partner_name'] . '</b> on ' . date('F d, Y', strtotime($r['auction_response_post_time'])); ?></p>
		<p><?php echo $r['auction_response_offer']?></p>
		<p><?php echo $r['auction_response_comment']; ?></p>
		<br /><br />
<?php
		}
	}
?>
</div>

</body>
</html>
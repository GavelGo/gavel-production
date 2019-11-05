<?php
// require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
require '../classes/Pusher.php';
// require '../classes/Utilities.php';
require '../classes/Websocket.php';
require '../classes/Sanitation.php';
require '../models/coupon.php';
require '../scripts/file_upload.php';

ini_set('display_errors', 1);

use PartnerDomain\Sanitation;

$_SESSION['partner_id'] = 1;
$_SESSION['partner_hash'] = "temp5r6tyfgjhk";
$_SESSION['partner_name'] = 'tarin co';
// put these here, so partner cannot choose
$_SESSION['category_hash'] = "576atiuyoudlhfj";
$_SESSION['category_id'] = 1;
$_SESSION['category_name'] = 'Outdoor';

if(isset($_POST['submit'])){
	$_POST['category_hash'] = $_SESSION['category_hash'];
	$_POST['coupon_category_id'] = $_SESSION['category_id'];
	$_POST['coupon_category_name'] = $_SESSION['category_name'];

	$clean_post = PartnerDomain\Sanitation::clean_data($_POST);
	$coupon = CouponModel::add($_SESSION['partner_id']);
	$socket = Websocket::connect_publisher();

    $message = array(
    	'hash'                => $coupon->hash,
    	'title'               => $coupon->title,
    	'coupon_description'  => $coupon->description,
    	'coupon_start_date'   => $coupon->start_date,
    	'coupon_end_date'     => $coupon->end_date,
    	'coupon_restrictions' => $coupon->restrictions,
    	'coupon_photo_one'    => $coupon->photo_one,
    	'partner_hash'        => $_SESSION['partner_hash'],
    	'partner_name'        => $_SESSION['partner_name'],
    	'category_hash'       => $_SESSION['category_hash'],
    	'category_name'       => $_SESSION['category_name'],
    	'submission_type'     => $clean_post['submission_type'],
    	'content_type'        => $clean_post['content_type']
    );


    $socket->send(json_encode($message));
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="../assets/js/textCounter.js"></script>
</head>
<body>

<h1>post-push</h1>
<h2>submit coupon</h2>
	<br />
	<form enctype="multipart/form-data" action="/partners-subdomain/notifications/post-push.php" method="POST" id="addCouponForm">
		<label for="title">Title(*)</label>
		<br />
		<input type="text" name="coupon_title" autocomplete="off" required="required">
		<br />
		<label for="coupon_description">Description(*)</label>
		<br />
		<textarea rows="5" cols="20" id="cd" autocomplete="off" name="coupon_description" maxlength="255" required="required" placeholder="Add additional info here..." onkeyup="textCounter('remainingDescriptionCharacters', 'cd', 255)"></textarea>
		<span id="remainingDescriptionCharacters">0/255</span>
		<br />
		<input type="hidden" name="partner_id" value="<?php echo $_SESSION['partner_id']; ?>" />
		<label for="coupon_start_date">Start Date(*)</label>
		<br />
		<input type="date" name="coupon_start_date" required="required" placeholder="mm/dd/yyyy">
		<br />
		<label for="coupon_end_date">End Date(*)</label>
		<br />
		<input type="date" name="coupon_end_date" required="required" placeholder="mm/dd/yyyy">
		<br />
		<label for="coupon_restrictions">Restrictions(Optional)</label>
		<br />
		<textarea rows="5" cols="20" name="coupon_restrictions" maxlength="255" placeholder="Add any restrictions here..." onkeyup="textCounter('remainingRestrictionCharacters', 'cd', 255)"></textarea>
		<span id="remainingRestrictionCharacters">0/255</span>
		<br />
		<label for="coupon_photo">Photo(Recommended)</label>
		<br />
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
		<input name="coupon_photo_1" type="file" />
		<input name="coupon_photo_2" type="file" />
		<input name="coupon_photo_3" type="file" />
		<input name="coupon_photo_4" type="file" />
		<input name="coupon_photo_5" type="file" />
		<br />
		<!-- submission type for Ratchet -->
		<input type="hidden" name="submission_type" value="partnerActivity" />
		<input type="hidden" name="content_type" value="coupon" />
		<br /><br />
		<input type="submit" name="submit" value="Add">
	</form>

<h2>submit auction</h2>
	<br />
	<form enctype="multipart/form-data" action="/notifications/post-push.php" method="POST" id="addAuctionForm">
		<label>category</label>
		<br />
		<select name="category_hash" required="required">
		  <option value="576atiuyoudlhfj">Outdoor</option>
		  <option value="q7i4yplughgsff">Catering</option>
		</select>
		<br />
		<label for="title">Title(*)</label>
		<br />
		<input type="text" name="title" autocomplete="off" required="required">
		<br />
		<label for="auction_description">Description(*)</label>
		<br />
		<textarea rows="5" cols="20" id="cd" autocomplete="off" name="auction_description" maxlength="255" required="required" placeholder="Add additional info here..." onkeyup="textCounter('remainingDescriptionCharacters', 'cd', 255)"></textarea>
		<span id="remainingDescriptionCharacters">0/255</span>
		<br />
		<input type="hidden" name="partner_id" value="<?php echo $_SESSION['partner_id']; ?>" />
		<label for="auction_start_date">Start Date(*)</label>
		<br />
		<input type="date" name="auction_start_date" placeholder="mm/dd/yyyy">
		<br />
		<label for="auction_end_date">End Date(*)</label>
		<br />
		<input type="date" name="auction_end_date" placeholder="mm/dd/yyyy">
		<br />
		<label for="auction_restrictions">Restrictions(Optional)</label>
		<br />
		<textarea rows="5" cols="20" name="auction_restrictions" maxlength="255" placeholder="Add any restrictions here..." onkeyup="textCounter('remainingRestrictionCharacters', 'cd', 255)"></textarea>
		<span id="remainingRestrictionCharacters">0/255</span>
		<br />
		<label for="auction_photo">Photo(Recommended)</label>
		<br />
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
		<input name="auction_photo" type="file" />
		<br />
		<!-- submission type for Ratchet -->
		<input type="hidden" name="submission_type" value="partnerActivity" />
		<input type="hidden" name="content_type" value="auction" />
		<br /><br />
		<input type="submit" name="submit" value="Add">
	</form>
</body>
</html>
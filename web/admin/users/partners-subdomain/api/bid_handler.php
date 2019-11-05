<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/classes/Model.php');
require($_SERVER['DOCUMENT_ROOT'] . '/models/partner.php');
require($_SERVER['DOCUMENT_ROOT'] . '/classes/Sanitation.php');

# give default result value of pending: 
$clean_post = array('result' => 'pending');
foreach ($_POST as $key => $value) {
	$clean_post[$key] = Sanitation::clean_data($value);
}

$partner = PartnerModel::get_by_name($clean_post['partner_name']);
if(!is_null($partner)){
	switch ($clean_post['request']) {
		case 'leave_response':
			if($partner->leave_response_on_bid($clean_post['bid_id'], $clean_post['response_comment'], $clean_post['response_offer'])){
				$clean_post['result'] = 'success';
				$json_encoded_response = json_encode($clean_post);
				echo $json_encoded_response;
			}
			else {
				echo json_encode(array('result' => 'Could not submit response! Please try again.'));
			}
			break;

		case 'delete_response':

			break;
		
		default:
			echo "0: default";
			break;
	}
}

?>
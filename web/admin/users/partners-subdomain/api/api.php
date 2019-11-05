<?php
require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/config.php');
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/classes/Model.php');
require($_SERVER['DOCUMENT_ROOT'] . '/models/user.php');
require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/classes/Sanitation.php');
require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/models/auction.php');
require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/models/coupon.php');
require($_SERVER['DOCUMENT_ROOT'] . '/partners-subdomain/models/Notification.php');

use PartnerDomain\Model;
use PartnerDomain\Notification;
use PartnerDomain\Sanitation;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = PartnerDomain\Sanitation::clean_data($_POST);   
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request = PartnerDomain\Sanitation::clean_data($_GET);   
}

if (!isset($request['action'])) {
	$request['action'] = null;
}

if (!isset($request['model'])) {
	$request['model'] = null;
}

$response['result'] = 'pending';
$model = null;

switch ($request['model']) {
	case 'coupon':
		if (!isset($request['coupon_hash'])) {
			$request['coupon_hash'] = '';
		}
		$model = CouponModel::getByHash($request['coupon_hash']);
		break;

	case 'auction':
		if (!isset($request['auction_hash'])) {
			$request['auction_hash'] = '';
		}
		$model = AuctionModel::getByHash($request['auction_hash']);
		break;

	case 'partner':
		if (!isset($request['partner_hash'])) {
			$request['partner_hash'] = '';
		}
		$model = PartnerModel::getByHash($request['partner_hash']);
		break;

	case 'user':
		if (!isset($request['user_id'])) {
			$request['user_id'] = 0;
		}
		$model = UserModel::get_by_id($request['user_id']);
		break;

	case 'notification':
		break;
	
	default:
		$response['result'] = 'error: no business object applicable to request';
		echo json_encode($response);
		exit(1);
}

switch ($request['action']) {
	// AUCTIONS
	case 'place_bid':
		$affectedRows = $model->makeBid($request['user_id'], $request['bid']);
		$response['affected_rows'] = $affectedRows;
		$response['result'] = 'success';
		break;

	case 'get_bid_history':
		$response = array(
			'result' => 'pending'
		);
		$history = $model->getBidHistory();
		
		if ($history != null) {
			$response['result']  = 'success';
			$response['history'] = $history;
		}
		break;

	// USERS
	case 'save_or_unsave_coupon':
		switch($model->isCouponSaved($request['coupon_id'])){
			case 0:
				if($model->saveCoupon($request['coupon_id'])){
					$response['result'] = 'success';
					$response['saved_or_unsaved'] = 'saved';
				}	
				else {
					$response['result'] = 'failure';
				}
				break;
			case 1: 
				if($model->unsaveCoupon($request['coupon_id']) === 1){
					$response['result'] = 'success'; 
					$response['saved_or_unsaved'] = 'unsaved';
				}	
				else {
					$response['result'] = 'failure';
				}
				break;
			case -1:
				$response['result'] = 'error';
				break;
			default:
				break;
		}
		break;

	case 'save_or_unsave_partner':
		switch($model->isPartnerSaved($request['partner_id'])){
			case 0:
				if($user->savePartner($request['partner_id']) === 1){
					$response['result'] = 'success';
					$response['saved_or_unsaved'] = 'saved';
				}	
				else {
					$response['result'] = 'failure';
				}
				break;
			case 1: 
				if($model->unsavePartner($request['provider_id'])){
					$response['result'] = 'success'; 
					$response['saved_or_unsaved'] = 'unsaved';
				}	
				else {
					$response['result'] = 'failure';
				}
				break;
			case -1:
				$response['result'] = 'error';
				break;
			default:
				break;
		}
		break;

	default:
		$response['result'] = 'error: bad request';
		break;

	// USERS
	case 'save_user_notification_status':
		$insert_id = Notification::saveUserNotificationStatus($request['notification_id'], $request['user_id'], $request['is_read']);

		$response['insert_id'] = $insert_id;
		if ($insert_id > 0) {
			$response['result'] = 'success';
		}
		else {
			$response['result'] = 'failure';
		}

		break;

	case 'set_notification_as_read':
		$response['affected_rows'] = Notification::setUserNotificationAsRead($request['notification_id'], $request['user_id']);

		if ($response['affected_rows'] > 0) {
			$response['result'] = 'success';
		}
		else {
			$response['result'] = 'failure';
		}
	    break;
}

echo json_encode($response);
?>
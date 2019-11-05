<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/classes/Model.php');
require($_SERVER['DOCUMENT_ROOT'] . '/classes/Sanitation.php');
require($_SERVER['DOCUMENT_ROOT'] . '/models/partner.php');
$partner = new PartnerModel();

if(isset($_POST['partner_id'])){
	$partner = $partner->get_by_id($_POST['partner_id']);
	if(!is_null($partner)){
		switch ($_POST['request']) {
			case 'category_change':
				echo "category_change";
				break;
			case 'update_profile':
				$status = $partner->update($_POST['partner_id']);
				switch ($status) {
					case -1:
						echo "Error updating profile. Please try again or contact us.";
						break;
					case 0:
						echo "No changes made.";
						break;
					case 1:
						echo "Updated successfully.";
						break;
					default:
						break;
				}
				break;

			case 'delete_post':
				$status = $partner->delete_post($_POST['post_id']);
				switch ($status) {
					case -1:
						echo "Error deleting post. Please try again or contact us.";
						break;
					case 0:
						echo "No post to delete.";
						break;
					case 1:
						echo "Deleted.";
						break;
					default:
						break;
				}
				break;
		
			default:
				break;
		}
	}
	
}

?>
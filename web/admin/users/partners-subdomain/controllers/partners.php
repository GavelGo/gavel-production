<?php
/**
*
*/
class Partners extends Controller {
	protected function index(){
		$this->return_view(PartnerModel::index(), true);
	}

	protected function profile(){
		$this->return_view(PartnerModel::profile($this->request['param']), true);
	}

	protected function edit_profile(){
		$view_model = new PartnerModel('partner', 'php');
		$this->return_view($view_model->edit_profile($this->request['id']), true);
	}

	protected function account(){
		$this->return_view(PartnerModel::account(), true);
	}

	protected function myAuctions(){
		$view_model = new PartnerModel('partner', 'php');
		if(isset($_SESSION['partner_id'])){
			$this->return_view($view_model->myAuctions($_SESSION['partner_id']), true);
		}
		else {
			$this->return_view($view_model->myAuctions(), true);
		}
	}

	protected function add(){
		$this->return_view(PartnerModel::add(), true);
	}
}
?>

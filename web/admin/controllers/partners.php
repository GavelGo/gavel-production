<?php
/**
*
*/
class Partners extends Controller{
	/**
	*
	*/
	protected function index(){
		$view_model = new PartnerModel();
		$this->return_view($view_model->index(), true);
	}

	/**
	*
	*/
	protected function profile(){
		$view_model = new PartnerModel();
		$this->return_view($view_model->profile(), true);
	}

	/**
	*
	*/
	protected function listings(){
		$view_model = new PartnerModel();
		if(isset($_SESSION['partner_name'])){
			$this->return_view($view_model->listings($_SESSION['partner_name']), true);
		}
		else {
			$this->return_view($view_model->listings(), true);
		}
	}

	/**
	* 
	*/
	protected function account(){
		$view_model = new PartnerModel();
		$this->return_view($view_model->account(), true);
	}

	/**
	* 
	*/
	protected function add(){
		$view_model = new PartnerModel();
		$this->return_view($view_model->add(), true);
	}
}
?>

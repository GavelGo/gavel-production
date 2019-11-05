<?php
class Auctions extends Controller {
	protected function index(){
		$view_model = new AuctionModel('auction', 'php');
		$this->return_view($view_model->index(), true);
	}

	protected function add(){
			$view_model = new AuctionModel('auction', 'php');
			$this->return_view($view_model->add($this->request['param']), true);
	}

	protected function profile(){
		$view_model = new AuctionModel('auction', 'php');
		$this->return_view($view_model->profile($this->request['param']), true);
	}
}
?>

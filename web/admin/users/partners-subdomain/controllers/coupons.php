<?php
class Coupons extends Controller {
	protected function index(){
		$view_model = new CouponModel('coupon', 'php');
		$this->return_view($view_model->index(), true);
	}

	protected function add(){
		$this->return_view(CouponModel::add(), true);
	}

	protected function edit(){
		$view_model = new CouponModel('coupon', 'php');
		$this->return_view($view_model->edit(), true);
	}

	protected function profile(){
		$view_model = new CouponModel('coupon', 'php');
		$this->return_view($view_model->profile($this->request['param']), true);
	}
}
?>
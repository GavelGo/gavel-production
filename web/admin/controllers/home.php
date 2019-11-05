<?php
/**
*
*/
class Home extends Controller{
	/**
	*
	*/
	protected function index(){
		$view_model = new HomeModel();
		$this->return_view($view_model->index(), true);
	}

	/**
	*
	*/
	protected function login(){
		$view_model = new HomeModel();
		$this->return_view($view_model->login(), true);
	}

	/**
	*
	*/
	protected function logout(){
		$view_model = new HomeModel();
		$this->return_view($view_model->logout(), true);
	}

	/**
	*
	*/
	protected function register(){
		$view_model = new HomeModel();
		$this->return_view($view_model->register(), true);
	}

	/**
	*
	*/
	protected function support(){
		$view_model = new HomeModel();
		$this->return_view($view_model->support(), true);
	}

	/**
	*
	*/
	protected function notfound(){
		$view_model = new HomeModel();
		$this->return_view($view_model->notfound(), true);
	}
}

?>
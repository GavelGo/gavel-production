<?php
class Employees extends Controller {
	protected function index(){
		$view_model = new EmployeeModel();
		$this->return_view($view_model->index(), true);
	}

	protected function login(){
		$view_model = new EmployeeModel();
		$this->return_view($view_model->login(), true);
	}

	protected function logout(){
		$view_model = new EmployeeModel();
		$this->return_view($view_model->logout(), true);
	}

	protected function hours(){
		$view_model = new EmployeeModel();
		$this->return_view($view_model->hours(), true);
	}

	protected function profile(){
		$view_model = new EmployeeModel();
		$this->return_view($view_model->profile($this->request['id']), true);
	}
}
?>
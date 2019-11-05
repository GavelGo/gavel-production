<?php
class Home extends Controller {
	protected function index(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->index(), true);
	}

	protected function notifications() {
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->notifications(), true);
	}

	protected function login(){
		$this->return_view(HomeModel::login(), true);
	}

	protected function logout(){
		$this->return_view(HomeModel::logout(), true);
	}

	protected function register(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->register(), true);
	}

	protected function verify(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->verify(), true);
	}

	protected function activate(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->activate($this->request), true);
	}

	protected function support(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->support(), true);
	}

	protected function feedback(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->feedback(), true);
	}

	protected function contact(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->contact(), true);
	}	

	protected function notfound(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->notfound(), true);
	}

	protected function info(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->info(), true);
	}

	protected function terms(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->terms(), true);
	}

	protected function careers(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->careers(), true);
	}

	protected function recover(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->recover(), true);
	}

	protected function comingsoon(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->comingsoon(), true);
	}

	protected function gavelgo(){
		$view_model = new HomeModel('home', 'PHP');
		$this->return_view($view_model->gavelgo(), true);
	}
}
?>
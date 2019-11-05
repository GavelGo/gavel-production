<?php
use PartnerDomain\UserModel;
/**
*
*/
class Users extends Controller
{
	protected function index()
	{
		$view_model = new UserModel();
		$this->return_view($view_model->index(), true);
	}

	public function login()
	{
		$view_model = new UserModel();
		$this->return_view($view_model->login(), true);
	}

	protected function register()
	{
		$view_model = new UserModel();
		$this->return_view($view_model->register(), true);
	}

	protected function verify()
	{
		$view_model = new UserModel();
		$this->return_view($view_model->verify(), true);
	}

	protected function logout()
	{
		$view_model = new UserModel();
		$this->return_view($view_model->logout(), true);
	}

	protected function profile()
	{
		$view_model = new UserModel();
		if (isset($_SESSION['user_id'])) {
			$this->return_view($view_model->profile($_SESSION['user_id']), true);
		}
		else {
			$this->return_view($view_model->profile(0), true);			
		}
	}

	/**
	*
	*/
	protected function auctions()
	{
		$view_model = new UserModel();
		$this->return_view($view_model->auctions());
	}
}
?>

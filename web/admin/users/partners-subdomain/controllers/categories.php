<?php
/**
*
*/
class Categories extends Controller
{
	/**
	*
	*/
	protected function index()
	{
		$view_model = new CategoryModel();
		$this->return_view($view_model->index(), true);
	}

	/**
	*
	*/
	protected function profile()
	{
		$view_model = new CategoryModel();
		$this->return_view($view_model->profile($this->request['id']), true);
	}

	/**
	*
	*/
	protected function sub()
	{
		$view_model = new CategoryModel();
		$this->return_view($view_model->sub_profile($this->request['id']), true);
	}
}
?>

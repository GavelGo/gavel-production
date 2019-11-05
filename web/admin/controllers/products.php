<?php
/**
*
*/
class Products extends Controller{
	/**
	*
	*/
	protected function index(){
		$view_model = new ProductModel();
		$this->return_view($view_model->index(), true);
	}

	/**
	*
	*/
	protected function add(){
		# echo "<br />Test";
		$view_model = new ProductModel();
		$this->return_view($view_model->add(), true);
	}

	/**
	*
	*/
	protected function edit(){
		# echo "<br />Test";
		$view_model = new ProductModel();
		$this->return_view($view_model->edit(), true);
	}

	/**
	*
	*/
	protected function profile(){
		$view_model = new ProductModel();
		$this->return_view($view_model->profile($this->request['id']), true);
	}
}
?>

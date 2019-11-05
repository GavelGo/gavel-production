<?php
/**
*
*/
class Search extends Controller
{
	/**
	*
	*/
	protected function index()
	{
		$view_model = new SearchModel();
		$this->return_view($view_model->index(), true);
	}

	/**
	*
	*/
	protected function subsearch()
	{
		$view_model = new SearchModel();
		$this->return_view($view_model->subsearch(), true);
	}
}
?>

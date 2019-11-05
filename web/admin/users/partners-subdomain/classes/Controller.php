<?php
abstract class Controller{
	protected $request;
	protected $action;

	public function __construct($action, $request){
		$this->action  = $action;
		$this->request = $request;
	}

	public function execute_action(){
		return $this->{$this->action}();
	}

	/**
	*
	*/
	protected function return_view($view_model, $full_view){
		# views folder slash class name. view folder named same as class(user class, user folder inside views). file should be named same as action
		$view = strtolower(get_class($this)) . '/' . strtolower($this->action) . '.php';
		// include header and footer
		if($full_view){
			// load main layout that wraps around view
			require("views/main.php");
		}
		else {
			require('views/' . $view);
		}
	}
}
?>
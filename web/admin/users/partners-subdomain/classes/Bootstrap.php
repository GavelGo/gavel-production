<?php
namespace PartnerDomain;
use PartnerDomain\Messages;

/**
* takes in request controller and action from URL, initiates controller
*/
class Bootstrap {
	public $controller;
	public $action;
	public $param;
	public $param_two;
	public $request;

	public function __construct ($request) {
		$this->request = $request;
		
		(!isset($request['controller']) || $this->request['controller'] === "") ? 
			$this->controller = "home" : 
			$this->controller = $this->request['controller'];
		
		(!isset($request['action']) || $this->request['action'] === "") ? 
			$this->action = "index" : 
			$this->action = $this->request['action'];
		
		(!isset($request['param']) || $this->request['param'] === "") ? 
			$this->param = null : 
			$this->param = $this->request['param'];
		
		(!isset($request['param_two']) || $this->request['param_two'] === "" || $this->request['param_two'] === $this->request['param']) ? 
			$this->param_two = null : 
			$this->param_two = $this->request['param_two'];
	}

	public function createController(){
		if(class_exists($this->controller)){
			$parents = class_parents($this->controller);
			if(in_array("Controller", $parents)){
				if(method_exists($this->controller, $this->action)){
					return new $this->controller($this->action, $this->request);
				}
				else {
					# method DNE
					$this->controller = 'home';
					$this->action = 'notfound';
					return new $this->controller($this->action, $this->request);
				}
			}
			else {
				# base controller not found
				$this->controller = 'home';
				$this->action = 'notfound';
				return new $this->controller($this->action, $this->request);
							}
		}
		else {
			# Controller DNE
			$this->controller = 'home';
			$this->action = 'notfound';
			return new $this->controller($this->action, $this->request);
		}
	}
}
?>
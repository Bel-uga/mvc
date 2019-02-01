<?php
namespace Controllers;
use Classes\Controller;
use Models\UserModel;

Class indexController Extends Controller {

	public $layouts = "first_layouts";

	function index() {
		$this->template->view('index');
	}
	
}
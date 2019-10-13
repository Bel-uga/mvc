<?php
namespace Controllers;
use Classes\Controller;
use Models\UserModel;

class IndexController extends Controller
{
    public $layouts = "first_layouts";

    public function index()
    {
        $this->template->view('index');
    }
}

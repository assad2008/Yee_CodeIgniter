<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Unlogined_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->assign("welcome", "Welcome CodeIgniter");
        $this->view->display("main.html");
    }
}

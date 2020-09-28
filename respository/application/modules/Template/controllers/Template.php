<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MX_Controller
{
	function __construct()
    {
        parent::__construct();

        $this->load->model('Mdl_template');
    }

    public function index()
    {

    }

    public function error()
    {
        $this->load->view('error');
    }

    public function notification()
    {
        return 0;
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends MX_Controller
{
    public function __construct()
    {       
        parent::__construct();

        Modules::run('AdminPanel/logged_in');
    }

    public function index()
    {
       $data['content'] = '404';
       $this->load->view('Template/template',$data);
    }

    public function access_denied()
    {
        $data['content'] = 'nonaccess';
        $this->load->view('Template/template',$data);
    }
}

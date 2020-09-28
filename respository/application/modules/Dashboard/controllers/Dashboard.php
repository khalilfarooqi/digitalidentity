<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
    public function __construct()
    {       
        parent::__construct();

        Modules::run('Authentication/logged_in');

        $this->load->model('Mdl_dashboard');
    }
   
    public function index()
    {
        //dd( $this->session->userdata() );

        $data['content'] = 'dashboard';
        $this->load->view('Template/template',$data);
    }
}

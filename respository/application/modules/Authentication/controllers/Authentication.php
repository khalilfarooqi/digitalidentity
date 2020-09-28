<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Mdl_auth');
    }

    public function index()
    {
        if( $this->session->userdata('logged_in') ) {
            redirect(base_url().'Dashboard','refresh');
        }

        $data = array();

        $this->load->view('Authentication/authorize',$data);
    }

    private function _login( $data )
    {
        $is_user = $this->db->get_where(TABLE_USER, array(
            'username' => $data['username'], 'password' => $data['password']
        ), 1)->row_array();

        if ( $is_user ) {
            return TRUE;
        }

        return FALSE;
    }

    public function authorize()
    {
        $this->form_validation->set_rules('username','Username','required|trim|max_length[20]|min_length[4]|not_special_character', array(
            'not_special_character' => 'Special characters are not allowed in Username Field'
        ));
        $this->form_validation->set_rules('password','Password','required|trim|max_length[30]|min_length[8]');

        if ($this->form_validation->run() === FALSE)
        {
            $this->session->set_flashdata('msg', validation_errors() );
            redirect(base_url().'Authentication','refresh');
        }

        $login_auth = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        );

        if( $this->_login($login_auth) )
        {
            $this->session->set_userdata('userdata', $login_auth);
            $this->session->loggedin = true;

            return redirect('Dashboard');
        }

        $this->session->set_flashdata('postdata', $this->input->post());
        $this->session->set_flashdata('msg','The username or password is incorrect Plese try again');
        
        redirect(base_url().'Authentication','refresh');
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('Authentication');
    }

    public function logged_in()
    {
        if( !$this->session->loggedin )
        {
            redirect('Authentication');
        }
    }
}
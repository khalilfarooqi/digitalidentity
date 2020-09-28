<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_auth extends CI_Model
{
    public function __construct()
    {
        $this->table = null;

        parent::__construct();
    }
}
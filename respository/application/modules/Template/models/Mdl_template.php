<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_template extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->table = TABLE_PERMISSIONS;
	}

	public function getSidebarNavigations( $only_perms = array() )
	{
	    if( !isAdmin() ) {
            $this->db->where_in('id', count($only_perms) ? $only_perms  : 0 );
        }

        $this->db->order_by('sorting asc');

        return $this->db->get_where($this->table, array('is_enable' => 1))->result();
	} 

	public function get_all_modules_list($parent = 0)
	{
		return $this->db->get_where($this->table, array(
            'is_enable' => 1,
            'parent_id' => $parent
        ))->result_array();
	}
}
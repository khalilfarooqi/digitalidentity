<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	protected $ci;

	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->ci =& get_instance();
	}

    public function unique_name($str, $val)
    {
        $explode = explode(',', $val, 3);

        $table          = $explode[0] ?? 0;
        $transaction_id = $explode[1] ?? 0;
        $reference      = $explode[2] ?? 0;

        list($table, $column) = explode('.', $table, 2);

        if( !empty($transaction_id)) {
            $this->ci->db->where( ($reference ? $reference : 'id') . ' <>', $transaction_id);
        }

        $query = $this->ci->db->get_where($table, array(
            'is_enable <>' => 2,
            $column => $str
        ), 1);

        if( $query->row() ) {

            $this->ci->form_validation->set_message('unique_name', 'This value is already exists');

            return FALSE;
        }

        return TRUE;
    }

    public function unique_ref_name($str, $val)
    {
        $explode = explode(',', $val, 3);

        $table          = $explode[0] ?? 0;
        $transaction_id = $explode[1] ?? 0;
        $reference      = $explode[2] ?? 0;

        list($table, $column) = explode('.', $table, 2);

        if( !empty($transaction_id)) {
            $this->ci->db->where( ($reference ? $reference : 'id') . ' <>', $transaction_id);
        }

        $query = $this->ci->db->get_where($table, array(
            $column => $str
        ), 1);

        if( $query->row() ) {

            $this->ci->form_validation->set_message('unique_ref_name', 'This value is already exists');

            return FALSE;
        }

        return TRUE;
    }

	public function is_unique_update($str, $field)
	{
		$explode 		= explode('@', $field);
		$field_name 	= $explode['0'];
		$field_id_key 	= $explode['1'];
		$field_id_value = $explode['2'];

		sscanf($field_name, '%[^.].%[^.]', $table, $field_name);

		if(isset($this->ci->db))
		{
			$chk_bg = $this->ci->db->get_where('information_schema.COLUMNS', array(
				'COLUMN_NAME' => 'bg_code',
				'TABLE_NAME'=> $table,
				'TABLE_SCHEMA' => $this->ci->db->database
			))->num_rows() === 1;

			$where = array($field_name => $str, $field_id_key.'!=' => $field_id_value, 'is_active!=' => 2);

			($chk_bg == 1) ? $where['bg_code'] = $this->ci->session->userdata ( 'bg_code' ) : "";

			if($this->ci->db->limit(1)->get_where($table, $where)->num_rows() === 1)
			{
				$this->ci->form_validation->set_message('is_unique_update', 'The {field} field must contain a unique value.');

				return false;
			}
		}

		return true;
	}

	public function Not_single_zero($number)
	{
		if($number > floatval(0))
			return true;

		$this->ci->form_validation->set_message('Not_single_zero', 'The {field} must greater then Zero.');

		return false;
	}

	public function access_code_unique($str, $field)
	{
		$explode 		= explode('@', $field);
		$field_name 	= $explode['0'];
		$field_id_value	= $explode['1'];

		sscanf($field_name, '%[^.].%[^.]', $table, $field_name);

		if(isset($this->ci->db))
		{
			if($this->ci->db->limit(1)->select('*')->from($table)->where(json_decode($field_id_value,true))->get()->num_rows() > 0)
			{
				$this->ci->form_validation->set_message('access_code_unique', 'The {field} field must contain a unique value.');

				return false;
			}
		}

		return true;
	}

	public function update_code_unique($str, $field)
	{
		$explode 		= explode('@', $field);
		$field_name 	= $explode['0'];
		$field_id_value = $explode['1'];

		sscanf($field_name, '%[^.].%[^.]', $table, $field_name);

		if(isset($this->ci->db))
		{
			if($this->ci->db->limit(1)->select('*')->from($table)->where(json_decode($field_id_value,true))->get()->num_rows() != 1)
			{
				$this->ci->form_validation->set_message('access_code_unique', 'The {field} field must contain a unique value.');

				return false;
			}
		}

		return true;
	}

	public function check_date($str, $min)
	{
		if(strtotime($min) >= strtotime($str))
		{
			$this->ci->form_validation->set_message('check_date', 'The {field} must be greater than {param}.');

			return false;
		}

		return true;
	}
}
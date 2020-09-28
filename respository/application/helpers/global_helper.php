<?php defined('BASEPATH') OR exit('No direct script access allowed');

//============================================================+
// File name   : global_helper.php
// Begin       : 2018-04
// Last Update : 2018-04
//
// Description : method includes a variety of global "helper" PHP functions.
// Author      : Junaid Ahmed
// -------------------------------------------------------------------


/**
 * Codeigniter Instance
 * Load All Fileds once again
 *
 */

function get_ci_instance()
{
	$ci =& get_instance();

	return $ci;
}

/**
 * Generate Random No.
 *
 */
function random_number()
{
	return rand(1, 1000000);
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/**
 * Cross-site request forgery (CSRF)
 *
 */
function form_csrf_token( $is_return = false )
{
	$csrf_token = '<input type="hidden" name="'.csrf_token_field().'" value="'.csrf_token().'">';

	if( $is_return ) {
		return $csrf_token;
	}

	echo $csrf_token;
}

// Returns the CSRF token value (the $config['csrf_token_hash'] value).
function csrf_token()
{
	return get_ci_instance()->security->get_csrf_hash();
}

// Returns the CSRF token name (the $config['csrf_token_name'] name).
function csrf_token_field()
{
	return get_ci_instance()->security->get_csrf_token_name();
}

/**
 * The Carbon class is inherited from the PHP DateTime cla
 *
 */
function carbon( $date = NULL )
{
	return new DateTime($date);
}

// The today function creates a new current date:
function today( $format = NULL )
{
	$format = ($format ? $format : 'Y-m-d H:i:s');

	return carbon()->format($format);
}

function formated_date( $date, $format = NULL )
{
    $format = ($format ? $format : 'Y-m-d');

    return carbon($date)->format($format);
}

/**
 * Global Input Method Helper
 *
 */
function dropdown_default( $arr, $default = '' )
{
    if(count($arr)) {

        $arr[''] = $default;

        ksort($arr);

        return $arr;
    }

    return $arr;
}


/**
 * Global Helper Method
 */
function storage($file)
{
	return base_url('storage/'. ltrim($file, '/'));
}

function encrypt($pure_string)
{
    $dirty = array("+", "/", "=");
    $clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
    $encrypted_string = base64_encode(json_encode($pure_string));

    return str_replace($dirty, $clean, $encrypted_string);
}

function decrypt($encrypted_string)
{
    $dirty = array("+", "/", "=");
    $clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
    $decrypted_string = json_decode( base64_decode(str_replace($clean, $dirty, $encrypted_string)) , true );

    return $decrypted_string;
}


function get_sessions( $key = NULL, $return_by = false )
{
	$ci =& get_instance();

	$all = $ci->session->all_userdata();

	if( NULL == $key )
	{
		return $all;
	}
	else if( $all[$key] )
	{
		return $all[$key];
	}

	if( $return_by )
	{
		return null;
	}

	return [];
}

/**
 * Data Response
 * ----------------------------------
 */
function send_response( $status, $message, $data = array(), $collection = 'collection' )
{
	echo json_encode ([
		'status' 	=> $status,
		'message'   => $message,
		$collection => $data
	]);
	exit();
}

function include_file( $path, $module = NULL )
{
	$CI = get_ci_instance();

	$module = ($module ? $module : '');

	$CI->load->view( $module . '/' . $path);
}

function current_method()
{
    $CI = get_ci_instance();
    return $CI->router->fetch_method();
}

function current_controller($type = NULL)
{
	$CI = get_ci_instance();
	$class = $CI->router->fetch_class();

	if($type == 'l')
	{
		$class = lcfirst($class);
	}

	return $class;
}

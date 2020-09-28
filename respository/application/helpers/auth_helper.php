<?php defined('BASEPATH') OR exit('No direct script access allowed');

//============================================================+
// File name   : auth_helper.php
// Begin       : 2018-12
// Last Update : 2019-01
//
// Description : method includes a variety of project "helper" PHP functions.
// Author      : Junaid Ahmed
// -------------------------------------------------------------------

function ci(){
	$CI =& get_instance();

	return $CI;
}

function check_login(){
	return ci()->session->userdata('logged_in');
}

function auth( $param = null )
{
	if ( check_login() ){

		$auth = ci()->session->userdata('auth');

		if( isset($auth[$param])) {
			return $auth[$param];
		}

		return $auth;
	}

	return NULL;
}

function getUserType()
{
	return get_ci_instance()->session->user_type ?? NULL;
}

function isAdmin()
{
    if(auth('user_type') == 0) {
        return 1;
    }

    return 0;
}

function isNigran() {
    return (bool) getDataPermissionsParam("is_nigran");
}

function getUserLevel() {
    return getDataPermissionsParam("level_id");
}

function getUserId()
{
	return auth('id') ?? 0;
}

function getName(){

	if ( check_login() ){
		return auth()['name'];
	}

	return NULL;	
}

/**
 * Data Permissions
 * * * * * * * * * * * * * * * * * * * * * * *
 *
*/
function getDataPermissionsParam($param) {
    
    $perms = ci()->session->userdata('userdataperm');
    if( isset($perms[$param])) {
        return $perms[$param];
    }
    
    return null;
}

function getDataPermissions( $is_bool = true )
{
    $perms = ci()->session->userdata('userdataperm');

    dd($perms, $is_bool , "Data Permissions");
}
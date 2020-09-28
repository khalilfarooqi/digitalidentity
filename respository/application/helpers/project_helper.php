<?php defined('BASEPATH') OR exit('No direct script access allowed');

//============================================================+
// File name   : project_helper.php
// Begin       : 2018-12
// Last Update : 2019-01
//
// Description : method includes a variety of project "helper" PHP functions.
// Author      : Muhammad Mohsin
// -------------------------------------------------------------------

function alertMessage()
{
	$alerts = get_ci_instance()->session->flashdata();

	if (!empty($alerts))
	{
		$class='';
		$message = $alerts;
		$key     = array_keys($message)[0];
		$value   = array_values($message)[0];

		switch ($key)
		{
			case 'success':
				$class 		= 'alert-success';
				$ur_alert 	= 'کامیاب';
			break;

			case 'error':
				$class 		= 'alert-danger';
				$ur_alert 	= 'معزرت';
			break;

			case 'warning':
				$class 		= 'alert-warning';
				$ur_alert 	= 'خبردار';
			break;
		}

		echo '<div class="alert '.$class.'  alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>'.$key .' !</b> ' . $value.'
		</div>';
	}
}
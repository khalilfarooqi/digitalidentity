<?php defined('BASEPATH') OR exit('No direct script access allowed');

//============================================================+
// File name   : datetime_helper.php
// Begin       : 2019-03
// Last Update : 2019-03
//
// Description : method includes a variety of global "helper" PHP functions.
// Author      : Junaid Ahmed
// -------------------------------------------------------------------


function betweenTwoDates($from, $to)
{
	$date1 = new DateTime($from);
	$date2 = $date1->diff(new DateTime($to));
	
	return $date2->d;
}

function getMonthDateByMonthYear($year, $month)
{
	$list = array();

	for($d=1; $d<=31; $d++)
	{
		$time = mktime(12, 0, 0, $month, $d, $year);

		if ( date('m', $time) == $month )
			$list[] = date('Y-m-d', $time);
	}

	return $list;
}

/**
 * Returns the amount of weeks into the month a date is
 * @param $date a YYYY-MM-DD formatted date
 * @param $rollover The day on which the week rolls over
 */
function getWeekDateByMonthlyDate($monthly_date)
{
	$carbon 		= new DateTime( $monthly_date[0] );
	$first_week 	= $carbon->modify('first saturday')->format('Y-m-d');
	$month_format 	= $carbon->format('Y-m');

	$i= 0;

	$weeks = [];
	foreach ($monthly_date as $key => $value)
	{
		if( $first_week == $value ) {

			$i = 6;

			$weeks[$value] = getDatesFromRange($month_format . '-01', $value);
		}

		$i++;

		if( $i%7 == 0 && $i != 7){

			$i = $i+7;

			$start = date('Y-m-d', (strtotime('-6 day', strtotime($value))));

			$weeks[$value] = getDatesFromRange($start, $value);
		}
	}

	return $weeks;
}

function getDatesFromRange($start, $end, $format = 'Y-m-d')
{
    // Declare an empty array
    $array = array();

    // Variable that store the date interval
    // of period 1 day
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    // Use loop to store date into array
    foreach($period as $date) {
        $array[] = $date->format($format);
    }

    // Return the array elements
    return $array;
}

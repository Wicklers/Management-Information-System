<?php

/**
 * Retrieves privilege of the current logged in user
 * @return string
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @package MIS
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
function privilege(){
	if(Session::exists('privilege')){
		return Session::get('privilege');
	}
	else
		return NULL;
}
/**
 * Admin has a priority of 0
 * Director, Dean  has a priority of 1
 * HOD has a priority of 2
 * DUPC/DPPC has a priority of 3
 * Teacher has a priority of 4
 * Student has a priority of 5
 * @return integer
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @package MIS
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
function privilegePriority(){
	switch(privilege()){
		case 'admin':
			return 0;
		case 'director':
		case 'dean':
			return 1;
		case 'hod':
			return 2;
		case 'dupc':
		case 'dppc':
			return 3;
		case 'teacher':
			return 4;
		case 'student':
			return 5;
	}
}
?>
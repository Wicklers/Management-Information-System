<?php
/**
 * Tells whether user is logged in or not
 * @return boolean
 * @package MIS
 * @name LoggedIn
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
function loggedIn(){
	if(Session::exists('loggedIn') && Session::get('loggedIn')==1){
		return TRUE;
	}
	else
		return FALSE;
}
?>
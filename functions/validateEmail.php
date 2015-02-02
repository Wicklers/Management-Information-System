<?php
/**
 * Checks whether the given string is a valid email or not using regular expression of an email.
 * @param string $string , string which needs to be validated.
 * @return boolean
 * @package MIS
 * @name Validate Email
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
function validateEmail($string){
		$regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
	
		if($string == '') { 
			return false;
		} else {
			$check = preg_replace($regex, '', $string);
		}
	
		return empty($check) ? true : false;
	}
?>
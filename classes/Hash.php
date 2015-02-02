<?php
/**
 * @package MIS
 * @name Hash
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Hash{
		public static function make($string, $salt=''){
				return hash('sha256', $string . $salt);	
			}
		public static function salt($length){
				return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
			}
		public static function unique(){
				return self::make(uniqid());
			}			
	}
?>
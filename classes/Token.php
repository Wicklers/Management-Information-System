<?php

/**
 * @package MIS
 * @name Token
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Token{
		/**
		 * Generates Token for the request. Once per request should be used
		 */
		public static function generate() {
				return Session::put('token', md5(uniqid()));
			}
		/**
		 * Checks whether request comes from right token or not. If yes, delete the token and return true.
		 * @return boolean 
		 */
		public static function check($token){
				$tokenName = 'token';
				
				if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
						Session::delete($tokenName);
						return true;
					}
				else
					return false;
			}
		/**
		 * Checks whether request comes from right token or not. If yes it doesn't deletes the existing token and returns true.
		 * @return boolean 
		 */
        public static function check_a($token){
                $tokenName = 'token';
                
                if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
                        return true;
                    }
                else
                    return false;
            }
	}
?>
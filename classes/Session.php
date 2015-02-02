<?php
/**
 * @package MIS
 * @name Session
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Session{
		public static function put($name, $value){
				return $_SESSION[$name] = $value;
			}
			
		public static function exists($name){
				return (isset($_SESSION[$name]))?true:false;
			}
			
		public static function get($name){
				return (isset($_SESSION[$name])?$_SESSION[$name]:''); //returning value stored in that session name!!!
			}
		
		public static function delete($name){
				if(self::exists($name)){
						unset($_SESSION[$name]); //deleting the session
					}
			}
		public static function flash($name, $string = ''){
				if(self::exists($name)){
						$session = self::get($name);
						self::delete($name);
						return $session; 
					}
				else{
						self::put($name,$string);
					}
			}
		public static function destroy(){
				session_destroy();
			}
		public static function loginAttempt($type=''){
				switch($type){
						case 'password':
							if(self::exists('loginAttemptP')){
									switch(self::get('loginAttemptP')){
											case 1:
												self::put('loginAttemptP',2);
												return 2;
											break;
												
											case 2:
												self::put('loginAttemptP',3);
												return 3;
											break;
											
											case 3:
												//Re-captcha call for login system!!
												return 0;
											break;
										}
								}
							else{
									self::put('loginAttemptP', 1);
									return 1;
								}
						break;
						
						case 'OTP':
							if(self::exists('loginAttemptOTP')){
									switch(self::get('loginAttemptOTP')){
											case 1:
												self::put('loginAttemptOTP',2);
												return 2;
											break;
												
											case 2:
												self::put('loginAttemptOTP',3);
												return 3;
											break;
											
											case 3:												
												return 0; //blocking the user!!
											break;
										}
								}
							else{
									self::put('loginAttemptOTP', 1);
									return 1;
								}
						break;
						
						default:
							return 0;
						break;
					}
			}
		public static function deleteloginAttempt($type=''){
				switch($type){
						case 'password':
							self::delete('loginAttemptP');
						break;
						
						case 'OTP':
							self::delete('loginAttemptOTP');						
						break;
					}
				
			}
		
		public static function loginAttempts($type=''){
				switch($type){
						case 'password':
							return self::get('loginAttemptP');
						break;
						
						case 'OTP':
							return self::get('loginAttemptOTP');						
						break;
						
						default:
						break;
					}
				
			}
	}
?>
<?php
require_once 'includes/recaptchalib.php';
/**
 * @package MIS
 * @name Recaptcha
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Recaptcha{
		private $_publicKey, // 6LeJHPASAAAAAB18OTV1cFXz9GCzPNLrHCDA-Gdv
				$_privateKey; //6LeJHPASAAAAAIhLbqgwF8FX6lxoGNCLZXiRfDSx
		public function __construct($publicKey="6LdXXPQSAAAAAA22cy8Ux7jFRlX_UUwhOBWXM0hL", $privateKey="6LdXXPQSAAAAAFSvhR2vYV4BTY_eFVblPGFLjd5C"){
				$this->_publicKey = $publicKey;
				$this->_privateKey = $privateKey;
			}
		public function getPublicKey(){
				return $this->_publicKey;
			}
		private function getPrivateKey(){
				return $this->_privateKey;
			}
		public function display($theme='red'){ // themes : red, blackglass, clean<--, white
				$display =  "<script type='text/javascript'>
								var RecaptchaOptions = {
								    theme : '".$theme."'
								 };
							 </script>";
				$display .= recaptcha_get_html($this->_publicKey);
				return $display;
			}
		public function customDisplay(){ // themes : custom <----
				$display =  "<script type='text/javascript'>
								var RecaptchaOptions = {
								    theme : 'custom',
									custom_theme_widget : 'recaptcha_widget'
								 };
							 </script>";
				$display .= recaptcha_get_html($this->_publicKey);
				return $display;
			}
		public function verify(){
				$resp = recaptcha_check_answer($this->_privateKey,
                                $_SERVER["REMOTE_ADDR"],
                                Input::get('recaptcha_challenge_field'),
                                Input::get('recaptcha_response_field'));

				if (!$resp->is_valid) {
					// What happens when the CAPTCHA was entered incorrectly
				    return 0;
				} else {
					// Your code here to handle a successful verification :P
					return 1;
				}
		}
		
	}
?>
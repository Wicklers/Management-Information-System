<?php
/**
 * @package MIS
 * @name OTP
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class OTP{
		private $_mobile,
				$_message,
				$_CODE; //more api options listing here
		public function __construct(){
				$this->_username='test';
				$this->_password='123';	// RedSMS.in password
				$this->_senderID='TESTIN'; // Sender ID !!
				/*
				**
				**	MORE API Inputs assign here
				**
				*/
			}
		public function getMobile(){
				return $this->_mobile;
			}
		public function send($mobile=8402059135){

				$this->generateOTP();
				$this->_mobile =$mobile ;
				$this->_message = 'Your OTP for MIS/SIS login is '.$this->_CODE.'. NIT Silchar. Developed by Harsh Vardhan Ladha and Yogesh Chauhan.';

				// API call to send sms
				$sms = new SMS();
				if($sms->send($this->_mobile, $this->_message)){
					return 1;
				}
				else{
					echo 'OTP problem please try again later!';
					Session::delete('OTPCode');
					die();
				}
			}

		private function generateOTP(){
				function generatePassword($length, $strength){
							$vowels = 'aeuy';
							$consonants = 'bdghjmnpqrstvz';
							if ($strength & 1)
							{
								$consonants .= 'BDGHJLMNPQRSTVWXZ';
							}
							if ($strength & 2)
							{
								$vowels .= "AEUY";
							}
							if ($strength & 4)
							{
								$consonants .= '23456789';
							}
							if ($strength & 8)
							{
								$consonants .= '@#$%';
							}
							$password = '';
							$alt = time() % 2;
							for ($i = 0; $i < $length; $i++)
							{
								if ($alt == 1)
								{
									$password .= $consonants[(rand() % strlen($consonants))];
									$alt = 0;
								}
								else
								{
									$password .= $vowels[(rand() % strlen($vowels))];
									$alt = 1;
								}
						}
						return $password;
					}
				$this->_CODE = generatePassword(8,4);
				Session::put('OTPCode', $this->_CODE);
			}
		public function verifyOTP($response){
				if(Session::exists('OTPCode') && $response===Session::get('OTPCode')){
						Session::delete('OTPCode');
						return 1;
					}
				else{
						return 0;
					}
			}
	}

/** Using OTP Class.. Required : Input Class, Session Class, Redirect Class, init.php
**
********************************************************************************************************
********************************************************************************************************
********************************************************************************************************
****<?php																							****
****require_once 'core/init.php';																	****
****																								****
****if(!Input::exists()){																			****
****		?>																						****
****        <form method="post" action="index.php">													****
****        <input type="text" maxlength="10" placeholder="Enter Mobile Number" name="mobile"><br/>	****
****        <input type="submit" value="Send OTP">													****
****        </form>																					****
****        <?php																					****
****	}																							****
****else if(Input::exists() && Input::get('mobile')!=''){											****
****		$otp = new OTP();																		****
****		if($otp->send(Input::get('mobile')) && Session::loginAttempt('OTP')){					****
****				Session::put('OTP Sending', 'OTP Sent Successfully');							****
****				Redirect::to('index.php');														****
****			}																					****
****		else{																					****
****				echo "OTP Sending Error ... login attempt = " . Session::loginAttempts('OTP');	****
****			}																					****
****	}																							****
****if(Session::exists('OTP Sending')){																****
****		echo Session::get('OTP Sending') . "<br/>";												****
****		Session::delete('OTP Sending');															****
****		if(Session::loginAttempts('OTP')){														****
****			?>																					****
****        <form action="index.php" method="post">													****
****        <input type="text" maxlength="8" placeholder="Enter OTP Here" name="OTP_response_code"> ****
****        <input type="submit" Value="Verify">													****
****        </form>																					****
****        <?php																					****
****			}																					****
****		else{																					****
****				echo 'You have been blocked.. contact Administrator';							****
****			}																					****
****		}																						****
****if(Input::exists() && Input::get('OTP_response_code')!=''){										****
****		$otp=new OTP();																			****
****		if($otp->verifyOTP(Input::get('OTP_response_code'))){									****
****				Session::deleteloginAttempt('OTP');												****
****				echo 'Yipppeeee Verified';														****
****			}																					****
****		else{																					****
****				Session::put('OTP Sending', 'Incorrect, Enter Again');							****
****				if(Session::loginAttempt('OTP')){												****
****						Redirect::to('index.php');												****
****					}																			****
****																								****
****			}																					****
****	}																							****
****?>																								****
********************************************************************************************************
********************************************************************************************************
********************************************************************************************************
** Created by Harsh Vardhan Ladha // www.harshladha.in //
**/
?>


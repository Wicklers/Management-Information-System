<?php
require_once '../../core/init.php';

if(Input::exists('post')){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'otpcode' => array(
			'required' => true
		)
	));
	
	if($validate->passed() && Token::check_a(Input::get('token'))){
		
		$otp = new OTP();
		
		if($otp->verifyOTP(Input::get('otpcode'))){ 
			$stud = new Student();
			$ver = $stud->verifyMobile(Session::get('sn'));
			if($ver){
				echo 1;
			}
			else{
				echo "There is temporary problem. Please try again after some time.";
			}
		}
		else
			echo "Please enter correct One Time Password, otherwise you will be blocked from registration.";
	}
	else{
		echo "Please fill the required fields : ";
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'otpcode is required':
					echo 'One Time Password, ';
				break;
				default:
					echo '<li>' . $errors . '</li>';
				break;
			}
		}
	}
}
else
	echo 'here';
?>
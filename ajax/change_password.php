<?php
require_once '../core/init.php';

if(Input::exists('post') && privilege()!=NULL){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'cpwd' => array(
			'required' => true
		),
		'newpwd1' => array(
			'required' => true,
			'min' => 6,
			'matches' => 'newpwd2'
		)
	));
	
	if($validate->passed()){
		$ldap = new LDAP();
		if(!loggedIn() || $ldap->Auth(Session::get('teacher_email'), Input::get('cpwd'))!=1){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Invalid authentication. Please enter correct password or re-login.';
			echo '</div>';
			die();
			
		}else{
		$add = $ldap->changePassword(Session::get('teacher_email'), Input::get('newpwd1'));
			if($add==1){
				echo '<div class="alert alert-success alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	            echo 'Password changed successfully';
				echo '</div>';
			}
			else if($add==0){
				echo '<div class="alert alert-danger alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	            echo 'Temporary Error';
				echo '</div>';
			}
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'cpwd is required':
					echo 'Please enter current password<br/>';
				break;
				case 'newpwd1 is required':
					echo 'Please enter new password<br/>';
				break;
				case 'newpwd2 must match newpwd1':
					echo 'Passwords doesn\'t match<br/>';
				break;
				case 'newpwd1 must be minimum of 6 characters.':
					echo 'Please enter password above 6 character.<br/>';
				break;
				default:
					echo $errors;
				break;
			}
		}
		echo '</div>';
	}
}
?>

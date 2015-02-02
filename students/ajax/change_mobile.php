<?php
require_once '../../core/init.php';

if(Input::exists('post')){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'cpwd' => array(
			'required' => true
		),
		'mobile' => array(
			'required' => true,
			'min' => 10,
			'max' => 10
		)
	));
	
	if($validate->passed()){
		$t = new Student();
		$scholar_no=Session::get('sn');
		$mobile=preg_replace('/\s+/', '', Input::get('mobile'));
		if(strlen($mobile)!=10){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Please enter correct mobile number';
			echo '</div>';
		}
		else{
			$add = $t->changeMobile($scholar_no, $mobile);
			if($add==2){
				echo '<div class="alert alert-warning alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	            echo 'No changes made.';
				echo '</div>';
			}
			if($add==3){
				echo '<div class="alert alert-danger alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
				echo 'Invalid authentication. Please enter correct password or re-login.';
				echo '</div>';
			}
			else if($add==1){
				echo '<div class="alert alert-success alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	            echo 'Mobile changed successfully';
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
				case 'mobile is required':
					echo 'Please enter new mobile number<br/>';
				break;
				case 'mobile must be minimum of 10 characters.':
					echo 'Please enter valid mobile number<br/>';
				break;
				case 'mobile must be maximum of 10 characters.':
					echo 'Please enter valid mobile number<br/>';
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
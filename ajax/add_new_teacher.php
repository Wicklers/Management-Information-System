<?php
require_once '../core/init.php';

if(Input::exists('post') && privilege()!=NULL){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'name' => array(
			'required' => true
		),
		'email' => array(
			'required' => true,
			'email' => true
		),
		'privilege' => array(
			'required' => true
		),
		'mobile' => array(
			'required' => true,
			'min' => 10,
			'max' => 10
		),
	));
	
	if($validate->passed()){
		$dep = new Teacher();
		
		$add = $dep->add(Input::get('name'), Input::get('email'), Input::get('privilege'), Input::get('department'), Input::get('mobile'),'1');
		
		if($add==4){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Maximum no. of possible ' . Input::get('privilege') . ' exists.';
			echo '</div>';
		}
		else if($add==3){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Sorry, you don\'t have privilege to add <b>' . Input::get('privilege') . '</b>. ';
			echo '</div>';
		}
		else if($add==2){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Teacher already registered';
			echo '</div>';
		}
		else if($add==1){
			$log = new Log();
			$log->actionLog('Added Teacher');
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Teacher added successfully';
			echo '</div>';
		}
		else if($add==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Temporary Error';
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'name is required':
					echo 'Teacher name is required<br/>';
				break;
				case 'username is required':
					echo 'Username is required<br/>';
				break;
				case 'email is required':
					echo 'Email-id is required<br/>';
				break;
				case 'privilege is required':
					echo 'Please select privilege<br/>';
				break;
				
				case 'mobile is required':
					echo 'Mobile no. is required<br/>';
				break;
				case 'mobile must be minimum of 10 characters.':
					echo 'Please enter valid mobile number<br/>';
				break;
				case 'mobile must be maximum of 10 characters.':
					echo 'Please enter valid mobile number<br/>';
				break;
				case 'email is invalid':
					echo 'Please enter valid Email-id<br/>';
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
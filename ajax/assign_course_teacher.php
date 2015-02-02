<?php
require_once '../core/init.php';

if(Input::exists('post') && privilege()!=NULL){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'coursecode' => array(
			'required' => true
		),
		'department' => array(
			'required' => true
		),
		'teacher' => array(
			'required' => true
		),
		'semester' => array(
			'required' => true
		)
	));

	if($validate->passed()){
		$course = new Course();
		
		$add = $course->appointCourse(Input::get('teacher'), Input::get('coursecode'), Input::get('semester'), Input::get('department'));
		
		if($add==3){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Sorry, This teacher is not yet approved to use this system.';
			echo '</div>';
			
		}
		else if($add==2){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Same course is already assigned to same teacher in this department.';
			echo '</div>';
		}
		else if($add==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Course assigned to teacher successfully.';
			echo '</div>';
		}
		else if($add==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Temporary Error!';
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'coursecode is required':
					echo 'Please select course.<br/>';
				break;
				case 'department is required':
					echo 'Please select department.<br/>';
				break;
				case 'teacher is required':
					echo 'Please select teacher.<br/>';
				break;
				case 'semester is required':
					echo 'Please provide semester.<br/>';
				break;
				default:
					echo $errors;
				break;
			}
		}
	}
}
?>
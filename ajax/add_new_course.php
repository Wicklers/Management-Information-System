<?php
require_once '../core/init.php';

if(Input::exists('post') && privilege()!=NULL){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'coursecode' => array(
			'required' => true
		),
		'coursename' => array(
			'required' => true
		),
		'department' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$dep = new Course();
		
		$add = $dep->add(Input::get('coursecode'), Input::get('coursename'),  Input::get('department'), Input::get('credit'));
		
		if($add==3){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Sorry, you don\'t have privilege to create department.';
			echo '</div>';
		}
		else if($add==2){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo Input::get('coursename') . ' Course already exists.';
			echo '</div>';
			
		}
		else if($add==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Course created successfully';
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
				case 'coursename is required':
					echo 'Course name is required<br/>';
				break;
				case 'coursecode is required':
					echo 'Course code is required<br/>';
				break;
				case 'department is required':
					echo 'Please select department<br/>';
				break;
				case 'credit is required':
					echo 'Please select course credit<br/>';
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
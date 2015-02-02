<?php
require_once '../core/init.php';

if(Input::exists() && privilege()!=NULL){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'name' => array(
			'required' => true
		),
		'id' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$dep = new Department();
		
		$add = $dep->add(Input::get('id'), Input::get('name'));
		
		if($add==3){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Sorry, you don\'t have privilege to create department.';
			echo '</div>';
		}
		else if($add==2){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo '<a href="view_department.php?id='.Input::get('id').'"> ' . Input::get('name') . '</a> Department already exists.';
			echo '</div>';
		}
		else if($add==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Department created successfully';
			echo '</div>';
		}
		else if($add==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            echo 'Temporary Error, while creating new department.';
			echo '</div>';
			
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'name is required':
					echo 'Department name is required<br/>';
				break;
				case 'id is required':
					echo 'Department-id is required<br/>';
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
<?php
require_once '../core/init.php';
if(Input::exists() && privilege()!=NULL && privilege()!='admin'){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
			'course_id' => array(
					'required' => true
			)
	));

	if($validate->passed()){
		if(empty($_FILES["file"]["tmp_name"])){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Please Select CSV File';
			echo '</div>';
			die();
		}
		$input = explode(',',Input::get('course_id'));
		$m = new Attendance();

		$import = $m->importCSV($input[0],$input[1], $_FILES["file"]["tmp_name"]);
		if($import){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo "Successfully Imported";
			echo '</div>';
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo "Temporary problem!";
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'course_id is required':
					echo 'Please select your course<br/>';
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
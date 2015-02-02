<?php
require_once '../core/init.php';
if(Input::exists() && privilege()!=NULL){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
			'course_id' => array(
					'required' => true
			),
			'examtype' => array(
					'required' => true
			),
			'category' => array(
					'required' => true
			)
	));

	if($validate->passed()){
		$m=new Marks();
		$lastdate = $m->getLastDate(Input::get('examtype'))->fetch_object()->date;
		$today = date('Y-m-d');
		if($today>=$lastdate){
			$date = date_create($lastdate);
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo "Last Date for ".strtoupper(Input::get('examtype'))." was ".date_format($date, 'd-M-Y');
			echo '</div>';
			die();
		}
		if(empty($_FILES["file"]["tmp_name"])){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Please Select CSV File';
			echo '</div>';
			die();
		}
		$input = explode(',',Input::get('course_id'));
		$m = new Marks();

		$import = $m->importCSV($input[0],$input[1], Input::get('examtype'), Input::get('category'), $_FILES["file"]["tmp_name"]);
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
				case 'examtype is required':
					echo 'Please select Exam Type from the list<br/>';
					break;
				case 'category is required':
					echo 'Please choose between regular course or load course<br/>';
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
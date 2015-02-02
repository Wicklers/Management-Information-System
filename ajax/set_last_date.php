<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists('post')){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'examtype' => array(
			'required' => true
		),
		'lastdate' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$dep = new Marks();
		$date = changeDateFormatToDB(Input::get('lastdate'));
		$setDate = $dep->setLastDate(Input::get('examtype'), $date);
		
		if($setDate==3){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo 'Sorry, you don\'t have privilege to set Last date for examination.';
			echo '</div>';
		}
		else if($setDate==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo 'Last date saved successfully.';
			echo '</div>';
		}
		else if($setDate==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo 'Temporary Error!';
			echo '</div>';
		}
        else if($setDate==4){
        	echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo 'No changes made.';
			echo '</div>';
        }
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'examtype is required':
					echo 'Please select exam type.<br/>';
				break;
				case 'lastdate is required':
					echo 'Please select last date.<br/>';
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
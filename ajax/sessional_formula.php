<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists()){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'formula' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$m = new Marks();
		
		$add = $m->setSessionalFormula(Session::get('teacher_id'),Input::get('ccode'), Input::get('cdep'), Input::get('formula'));
		if($add==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
    		echo 'Saved Successfully!';
			echo '</div>';
		}
		else if($add==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
    		echo 'Temporary Error!';
			echo '</div>';
		}
		else if($add==2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
    		echo 'No changes made!';
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'formula is required':
					echo 'Please choose formula before saving!<br/>';
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
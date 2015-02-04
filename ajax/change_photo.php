<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists('post') && Input::fileexists('photo')){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'submit' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$name = strtolower(preg_replace('/\s+/', '', Session::get('displayname')));
		$id = Session::get('teacher_id');
		$path = '/opt/lampp/htdocs/www/MIS/images/profile/';
		$filename = $name.$id.'.jpg';
		$photo = Input::image('photo',$path,$filename);
		
		if(!$photo){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Something went wrong!';
			echo '</div>';
		}
		if($photo){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Profile photo changed successfully!';
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'submit is required':
					echo 'Something went wrong.';
				break;
				default:
					echo $errors;
				break;
			}
		}
		echo '</div>';
	}
}
else{
	echo '<div class="alert alert-info alert-dismissible" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	echo 'Please browse and choose image of 500KB';
	echo '</div>';
}
?>

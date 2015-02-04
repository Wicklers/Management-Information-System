<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists('post')){
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
		
		$edit = $dep->edit_course(Input::get('coursecode'), Input::get('coursename'), Input::get('department'), Input::get('credit'));
		
		if($edit==3){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Sorry, you don\'t have privilege to edit course details.';
			echo '</div>';
		}
		else if($edit==2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Nothing changed.';
			echo '</div>';
		}
		else if($edit==1){
			$log = new Log();
			$log->actionLog('Edited Course');
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Course details changed successfully';
			echo '</div>';
		}
		else if($edit==0){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Temporary Error';
			echo '</div>';
		}
	}
	else{
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'coursename is required':
					echo '<li>Course name is required.</li>';
				break;
				case 'coursecode is required':
					echo '<li>Course code is required.</li>';
				break;
				case 'department is required':
					echo '<li>Please select department.</li>';
				break;
				case 'credit is required':
					echo '<li>Please select course credit.</li>';
				break;
				
				default:
					echo '<li>' . $errors . '</li>';
				break;
			}
		}
	}

	?>
				<script>
					save_edit_c();
				</script>
			<?php
}
?>
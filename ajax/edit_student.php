<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists('post')){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'scholar_no' => array(
			'required' => true
		),
		'mobile' => array(
			'required' => true,
			'min'	=> 10,
			'max'	=> 10
		),
		'parents_mobile' => array(
			'required' => true,
			'min'	=> 10,
			'max'	=> 10
		),
		'department' => array(
			'required' => true
		),
		'courses' => array(
			'required' => true
		),
		'total_score' => array(
			'required' => true
		),
		'max_score' => array(
			'required' => true
		),
		'home_address' => array(
			'required' => true
		),
		'hostel_address' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$stud = new Student();
		$edit = $stud->editInfo(Input::get('scholar_no'), Input::get('mobile'), Input::get('parents_mobile'), Input::get('department'), Input::get('courses'), Input::get('courses_load'), Input::get('total_score'), Input::get('max_score'), Input::get('home_address'), Input::get('hostel_address'), Input::get('approved'), Input::get('blocked'));
		if($edit==1){
			/*
			$log = new Log();
			if($teach->getApproved()==0 && Input::get('approved')==1){
				$log->actionLog('Approved Teacher');
			}
			if($teach->getApproved()==1 && Input::get('approved')==0){
				$log->actionLog('Disapproved Teacher');
			}
			if($teach->getBlocked()==1 && Input::get('blocked')==0){
				$log->actionLog('Unblocked Teacher');
			}
			if($teach->getBlocked()==0 && Input::get('blocked')==1){
				$log->actionLog('Blocked Teacher');
			}
			$log->actionLog('Edited Teacher');
			*/
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Student\'s information edited successfully.';
			echo '</div>';			
		}
		
		else if($edit==2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Nothing changed.';
			echo '</div>';
		}
		else if($edit==0){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Invalid authentication. Please try again later or re-login.';
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			
			switch($errors){
				case 'scholar_no is required':
					echo 'Something went wrong!<br/>';
				break;
				case 'total_score is required':
					echo 'Total Credit Score is required. Total credit score = summation(course credit point * grade scored by student) of all semesters till today.<br/>';
				break;
				case 'max_score is required':
					echo 'Total Credit Point is required. Total credit point = summation(course credit point) of all semesters till today.<br/>';
				break;
				case 'parents_mobile is required':
					echo 'Parents Mobile no. is required.<br/>';
				break;
				case 'parents_mobile must be minimum of 10 characters.':
					echo 'Please enter valid parents mobile number.<br/>';
				break;
				case 'parents_mobile must be maximum of 10 characters.':
					echo 'Please enter valid parents mobile number.<br/>';
				break;
				case 'mobile is required':
					echo 'Mobile no. is required.<br/>';
					break;
				case 'mobile must be minimum of 10 characters.':
					echo 'Please enter valid mobile number.<br/>';
					break;
				case 'mobile must be maximum of 10 characters.':
					echo 'Please enter valid mobile number.<br/>';
					break;
				case 'home_address is required':
					echo 'Home address is required.<br/>';
				break;
				case 'hostel_address is required':
					echo 'Hostel address is required.<br/>';
				break;
				default:
					echo $errors . '<br/>';
				break;
			}
		}
		echo '</div>';
	}

	?>
					<script>
						save_edit_s();
					</script>
				<?php
}
else
	echo 'here';
?>

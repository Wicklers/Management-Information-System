<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists('post')){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'name' => array(
			'required' => true
		),
		'email' => array(
			'required' => true,
			'email' => true
		),
		'privilege' => array(
			'required' => true
		),
		'mobile' => array(
			'required' => true,
			'min' => 10,
			'max' => 10
		),
	));
	
	if($validate->passed()){
		$teach = new Teacher();
		$teach->getInfoByEmail(Input::get('email'));
		$edit = $teach->edit_teacher_info(Input::get('name'),Input::get('t_id'),  Input::get('email'), Input::get('privilege'), Input::get('department'), Input::get('mobile'), Input::get('approved'), Input::get('blocked'));
		
		if($edit==4){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Maximum no. of possible ' . Input::get('privilege') . ' exists.';
			echo '</div>';			
		}
		else if($edit==3){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Sorry, you don\'t have privilege to edit teacher\'s information.';
			echo '</div>';
		}
		
		else if($edit==1){
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
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Teacher\'s information edited successfully.';
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
			echo 'Temporary Error';
			echo '</div>';
		}
	}
	else{
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'name is required':
					echo '<li>Teacher name is required.</li>';
				break;
				case 'username is required':
					echo '<li>Username is required.</li>';
				break;
				case 'email is required':
					echo '<li>Email-id is required.</li>';
				break;
				case 'privilege is required':
					echo '<li>Please select privilege.</li>';
				break;
				
				case 'mobile is required':
					echo '<li>Mobile no. is required.</li>';
				break;
				case 'mobile must be minimum of 10 characters.':
					echo '<li>Please enter valid mobile number.</li>';
				break;
				case 'mobile must be maximum of 10 characters.':
					echo '<li>Please enter valid mobile number.</li>';
				break;
				case 'email is invalid':
					echo '<li>Please enter valid Email-id.</li>';
				break;
				default:
					echo '<li>' . $errors . '</li>';
				break;
			}
		}
	}

	?>
					<script>
						save_edit_t();
					</script>
				<?php
}
else
	echo 'here';
?>
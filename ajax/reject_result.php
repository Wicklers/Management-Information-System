<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(loggedIn()){


	if(Input::exists('post')){
		$validate = new Validate();
		$validation = $validate->check($_POST,array(
			'reject_msg' => array(
				'required' => true
			)
		));
		if($validate->passed()){
			$tid = Input::get('tid');
			$cid = Input::get('cid');
			$did = Input::get('did');
			$reject_msg = Input::get('reject_msg');
			
			$a = new Approval();
			$b = $a->reject($tid,$cid,$did,$reject_msg);
			if($b===1){
				echo '<div class="alert alert-success alert-dismissible" role="alert">';
	    		echo 'Result rejected!';
				echo '</div>';
			}
			else if($b===2){
				echo '<div class="alert alert-warning alert-dismissible" role="alert">';
    			echo 'You cannot reject because you have already approved this result.';
				echo '</div>';
			}
			else if($b===0){
				echo '<div class="alert alert-danger alert-dismissible" role="alert">';
    			echo 'Temporary Problem!!';
				echo '</div>';
			}
		}
		else{
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			foreach($validate->errors() as $errors){
				switch($errors){
					case 'reject_msg is required':
						echo 'Please provide Reject Message.<br/>';
					break;
					default:
						echo $errors;
					break;
				}
			}
			echo '</div>';
		}
		
	}
}
?>
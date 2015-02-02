<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists()){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'name' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		$dep = new Department();
		
		$add = $dep->edit_dep(Input::get('id'), Input::get('name'));
		
		if($add==3){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Sorry, you don\'t have privilege to edit department.';
			echo '</div>';			
		}
		else if($add==2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Nothing changed.';
			echo '</div>';			
		}
		else if($add==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Department edited successfully.';
			echo '</div>';
		}
		else if($add==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Temporary Error';
			echo '</div>';
		}
		
	}
	else{
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'name is required':
					echo '<li>Department name is required</li>';
				break;
				
				default:
					echo '<li>' . $errors . '</li>';
				break;
			}
		}
	}
	?>
				<script>
					save_edit_dep();
				</script>
			<?php
}
?>
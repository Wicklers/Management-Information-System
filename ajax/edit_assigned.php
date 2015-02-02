<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists()){
    $validate = new Validate();
    $validation = $validate->check($_POST,array(
        'department' => array(
            'required' => true
        ),
        'semester' => array(
            'required'  => true
        ),
        'teacher' =>  array(
            'required'  => true
        )
    ));
    
    if($validate->passed()){
        $c = new Course();
        
        $add = $c->edit_appointed_course(Input::get('id'),Input::get('course_code'), Input::get('department'), Input::get('semester'), Input::get('teacher'));
        
        if($add==2){
            echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Nothing changed.';
			echo '</div>';
        }
        else if($add==1){
            echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Entry edited successfully';
			echo '</div>';
        }
        else if($add==0){
           echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Temporary Error';
			echo '</div>';
        }
        
    }
    else{
        foreach($validate->errors() as $errors){
            switch($errors){
                default:
                    echo '<li>' . $errors . '</li>';
                break;
            }
        }
    }

    ?>
    				<script>
    					save_edit_a();
    				</script>
    			<?php
}
?>

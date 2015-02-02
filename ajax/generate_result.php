<?php
require_once '../core/init.php';
if(!loggedIn()){
	die();
}
if(privilege()==NULL){
	die();
}
if(Input::exists()){
	if(Input::get('course_id')!=''){
		$var = explode(',',Input::get('course_id'));
		$m = new Marks();
        if(!$m->getGradeScale($var[0], $var[1])){
            echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo 'Set grading scale first!';
			echo '</div>';
            die();
        }
		$m->generateResult($var[0],$var[1]);
		$c = new Course();
		$c->getInfobyId($var[0]);
		?>
			<div class="box box-success">
				<div class="box-header">
					<h1 class="box-title">Final Result ( <?php echo $var[0] . ' - ' . $c->getCourseName(); unset($c); ?> )</h1>
					<button type="button" class="btn btn-success btn-lg pull-right" OnClick="approve(<?php echo '\''.Session::get('teacher_id').'\',\''.$var[0].'\',\''.$var[1].'\''; ?>);"><i class="glyphicon glyphicon-ok"></i> Approve Result!!</button>
				</div> <!-- ./box-header -->
				<div class="box-body">
					<?php
			        	
			        	include ROOT_DIR."results/result.php";
					
					
					?>
				</div> <!-- ./box-body -->
			</div>
			<script>
				function approve(tid,cid,did){
				    $('#updateModal').modal();
					$('#update').load('ajax/approve_result.php?tid='+tid+'&cid='+cid+'&did='+did);
				}
				
			</script>
		<?php
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    	echo 'Please select course from the list!';
		echo '</div>';
	}
}
else{
	echo '<div class="alert alert-danger alert-dismissible" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    echo 'Invalid Request';
	echo '</div>';
}
?>
<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(!loggedIn()){
	die();
}
if(Input::exists()){
	if(Input::get('course_id')!=''){
		$var = explode(',',Input::get('course_id'));
		$c = new Course();
		$c->getInfobyId($var[0]);
		?>
		
		<div class="box box-success">
			<div class="box-header">
				<h1 class="box-title">Final Result ( <?php echo $var[0] . ' - ' . $c->getCourseName(); unset($c); ?> )</h1>
				<form id="reject_result">
					<div class="form-group" id="reject" style="display:none;">
						<textarea name="reject_msg" placeholder="Give short reject comment." rows="4" class="form-control"></textarea>
						<input type="hidden" name="tid" value="<?php echo Session::get('teacher_id');?>" >
						<input type="hidden" name="cid" value="<?php echo $var[0];?>" >
						<input type="hidden" name="did" value="<?php echo $var[1];?>" >
						<button type="submit" class="btn btn-danger" name='submit'>Reject</button>
						<button type="button" OnClick="reject();" class="btn btn-danger" >Cancel</button>
					</div>
				</form>
				<button type="button" class="btn btn-danger btn-lg pull-right" OnClick="reject();"><i class="glyphicon glyphicon-remove"></i> Reject Result!!</button>
				<button type="button" class="btn btn-success btn-lg pull-right" OnClick="approve(<?php echo '\''.Session::get('teacher_id').'\',\''.$var[0].'\',\''.$var[1].'\''; ?>);"><i class="glyphicon glyphicon-ok"></i> Approve Result!!</button>				
			</div> <!-- ./box-header -->
			<div class="box-body">
				<?php
					include ROOT_DIR."results/result.php";
				?>		
			</div><!-- ./box-body -->
		</div>
		<!-- Page Scripts -->
			<script src="js/reject_result.js"></script>
			<script>
				function approve(tid,cid,did){
					$('#updateModal').modal();
					$('#update').load('ajax/approve_result.php?tid='+tid+'&cid='+cid+'&did='+did);
				}
				function reject(tid,cid,did){
					$('#reject').toggle();
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
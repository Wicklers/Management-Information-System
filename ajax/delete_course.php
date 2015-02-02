<?php
require_once '../core/init.php';
if(!Input::exists('get')){
	die();
}
if(privilege()==NULL){
	die();
}
else{
	$c = new Course();
	$c = $c->deleteCourse(Input::get('cid'));
	
	if($c==='Course has been Removed'){
		$log = new Log();
		$log->actionLog('Deleted Course');
		?>
			<script>
				save_edit_c();
			</script>
		<?php
	}
	echo '<div class="alert alert-danger alert-dismissible" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	echo $c;
	echo '</div>';
}
?>
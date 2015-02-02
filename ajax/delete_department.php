<?php
require_once '../core/init.php';
if(!Input::exists('get')){
	die();
	exit();
}
if(privilege()==NULL){
	die();
}
else{
	$dep = new Department();
	$del = $dep->deleteDep(Input::get('did'));
	
	if($del==='Department has been Deleted'){
		$log = new Log();
		$log->actionLog('Deleted Department');
		?>
			<script>
				save_edit_dep();
			</script>
		<?php
	}
	echo '<div class="alert alert-danger alert-dismissible" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    echo $del;
	echo '</div>';
}
?>
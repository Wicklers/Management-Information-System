<?php
require_once '../core/init.php';
if(!Input::exists('get')){
	die();
}
if(privilege()==NULL){
	die();
}
else{
	$dep = new Teacher();
	$del = $dep->deleteT(Input::get('tid'),Input::get('p'));
	
	
	if($del==='Teacher removed.'){
		$log = new Log();
		$log->actionLog('Removed Teacher');
		?>
		<script>
			save_edit_t();
		</script>
		<?php
	}
	echo '<div class="alert alert-danger alert-dismissible" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    echo $del;
	echo '</div>';
}
?>
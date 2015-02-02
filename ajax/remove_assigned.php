<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(!Input::exists('get')){
	die();
}
else{
    $c = new Course();
    $del = $c->remove_appointed_course(Input::get('cid'), Input::get('did'), Input::get('cs'));
    
    if($del==='Entry has been Deleted'){
        //$log = new Log();
        //$log->actionLog('Deleted Department');
        ?>
            save_edit_a();
        <?php
    }

    echo '<div class="alert alert-danger alert-dismissible" role="alert">';
    echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    echo $del;
    echo '</div>';
}
?>
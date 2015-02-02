<?php
require_once '../core/init.php';

if(loggedIn() && privilege()!=NULL ){
	if(Input::exists('get')){
		
		$tid = Input::get('tid');
		$cid = Input::get('cid');
		$did = Input::get('did');
		
		$a = new Approval();
		$b = $a->approve($tid,$cid,$did);
		if($b===1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
    		echo 'Result approved!';
			echo '</div>';
		}
		else if($b===2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
    		echo 'Already approved by you!';
			echo '</div>';
		}
		else if($b===0){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
    		echo 'Temporary Error!';
			echo '</div>';
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
    		echo $b;
			echo '</div>';
		}
		
	}
}
?>
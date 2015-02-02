<?php
require_once '../core/init.php';
if(Input::exists('get') && Input::get('a')!='' && (privilege()=='dean' || privilege()=='director' || privilege()=='admin')){
	$ab = Input::get('a');
	$s = new Semester();
	if($ab==1){
		$a = $s->startRegistration();
		if($a==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Registration process started.';
			echo '</div>';
		}
		else if($a==2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'No changes made.';
			echo '</div>';
		}
		else if($a==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Invalid authentication. Please try again later or re-login.';
			echo '</div>';
		}
	}
	if($ab==2){
		$a = $s->stopRegistration();
		if($a==1){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Registration process stopped.';
			echo '</div>';
		}
		else if($a==2){
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'No changes made.';
			echo '</div>';
		}
		else if($a==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Invalid authentication. Please try again later or re-login.';
			echo '</div>';
		}
	}
}
else{
	Session::destroy();
	include 'includes/errors/unauthorized.php';
	die();
}
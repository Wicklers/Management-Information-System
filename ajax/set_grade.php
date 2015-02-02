<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists()){

	if(Input::get('from_aa')>100){
		die("Grade AA cannot be more than 100.");
	}
	
	$scale="100,".Input::get('from_aa').",".Input::get('to_ab').",".Input::get('from_ab').",".Input::get('to_ba').",".Input::get('from_ba').",".Input::get('to_bb').",".Input::get('from_bb').",".Input::get('to_cc').",".Input::get('from_cc').",".Input::get('to_cd').",".Input::get('from_cd').",".Input::get('to_dd').",".Input::get('from_dd');
	$m = new Marks();
	$mm = $m->setGradingScale(Input::get('tid'),Input::get('cid'),Input::get('dep'),$scale);
	if($mm==1)
	{
		echo '<div class="alert alert-success alert-dismissible" role="alert">';
    	echo 'Saved Successfully!';
		echo '</div>';
	}
	else if($mm==0)
	{
		echo '<div class="alert alert-danger alert-dismissible" role="alert">';
    	echo 'Temporary Error!';
		echo '</div>';
	}
	else if($mm==2){
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
    	echo 'No changes made!';
		echo '</div>';
	}
	
	
}
?>
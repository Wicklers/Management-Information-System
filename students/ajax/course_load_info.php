<?php
require_once '../../core/init.php';
if(!loggedIn()){
	echo '-';
	die();
}
if(Session::get('type')!='student'){
	echo '-';
	die();
}
if(Input::exists('get') && Input::get('cid')!='' && Input::get('t')!=''){
	$c = new Course();
	$c->getInfobyId(Input::get('cid'));
	if(Input::get('t')==1)
		echo $c->getCourseName();
	else if(Input::get('t')==2)
		echo $c->getCourseCredit();
	else
		echo '-';
	unset($c);
}
echo '';
?>
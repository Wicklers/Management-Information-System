<?php
require_once '../core/init.php';
require_once ROOT_DIR.'functions/pie.php';

if(!loggedIn() || !Token::check_a(Input::get('token'))){
    die();
}
if(Input::exists('get')){
    $m = new Marks();
    $aa = $m->totalNumOfGivenGrade('10',Input::get('cid'),Input::get('did'));
    $ab = $m->totalNumOfGivenGrade('9',Input::get('cid'),Input::get('did'));
    $bb = $m->totalNumOfGivenGrade('8',Input::get('cid'),Input::get('did'));
    $bc = $m->totalNumOfGivenGrade('7',Input::get('cid'),Input::get('did'));
    $cc = $m->totalNumOfGivenGrade('6',Input::get('cid'),Input::get('did'));
    $cd = $m->totalNumOfGivenGrade('5',Input::get('cid'),Input::get('did'));
    $dd = $m->totalNumOfGivenGrade('4',Input::get('cid'),Input::get('did'));
    $f = $m->totalNumOfGivenGrade('0',Input::get('cid'),Input::get('did'));
    
    createPie3D(array("AA"=>$aa,"AB"=>$ab,"BB"=>$bb,"BC"=>$bc,"CC"=>$cc,"CD"=>$cd,"DD"=>$dd,"F/I/X"=>$f));
    
}
?>
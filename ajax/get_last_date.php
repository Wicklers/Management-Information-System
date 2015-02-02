<?php
require_once '../core/init.php';
if(!Input::exists('get')){
	die();
}
if(privilege()==NULL){
	die();
}
else if(Input::get('examtype')==''){ ?>
	<input type="text" placeholder="mm/dd/yyyy" class="form-control" data-provide="datepicker" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" name="lastdate" id="lastdate">
<?php }
else{
	$dep = new Marks();
	$last_date = $dep->getLastDate(Input::get('examtype'));
	if($last_date->num_rows){
		$last_date = changeDateFormatFromDB($last_date->fetch_object()->date);
		if($last_date=='00/00/0000'){
			$last_date='';
		}
	}
	else
		$last_date = '';
		
	
?>
<input type="text" placeholder="mm/dd/yyyy" class="form-control" data-provide="datepicker" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" name="lastdate" id="lastdate" value="<?php echo $last_date; ?>">
<?php 
}
?>
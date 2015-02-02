<?php
require_once '../core/init.php';
if(privilege()==NULL){
	die();
}
if(Input::exists()){
	$i=1; $j=0;$k=0;$status="Marks was left empty of Scholar Number :-";
		while((Input::get('scholar_number'.$i))){
			
			$m = new Marks();
			if(Input::get('marks'.$i)!='')
			{
				$mm = $m->MarksEntryLoad(Input::get('scholar_number'.$i),Input::get('c_code'),Input::get('c_dep'),Input::get('examtype'),Input::get('marks'.$i));
				if ($mm==2)
				{	
					$k++;
					//die("Something went wrong after Scholar number: ".Input::get('scholar_number'.$i)." . Please Try again.");
				}
				
			
			}
			else{
				$status = $status.Input::get('scholar_number'.$i).", ";
				$k++;
				$j++;
			}
			$i++;
		}
		if($k){
			echo "Number of rows effected:".($i-$k-1)."<br />";
		}
		if($j!=0)
		{
			$log = new Log();
			$log->actionLog('Saved Marks');
			echo $status . '<br/> Rest Saved Successfully.';
		}
		else{
			$log = new Log();
			$log->actionLog('Saved Marks');
			echo "Saved Successfully";
		}
}
?>
<?php
require_once '../core/init.php';
if(privilege()==NULL || privilege()=='teacher' || privilege()=='hod' || privilege()=='dupc' || privilege()=='dppc'){
	die();
}
$sem = new Semester();
$new = $sem->startNewSession();
if($new){
if(Session::exists('semester_session')){
        ?>
        <table class="table">
										<tr>
											<th>Session (year)</th>
											<td><?php echo Session::get('semester_session');?></td>
										</tr>
										<tr>
											<th>Type</th>
											<td><?php echo strtoupper(Session::get('semester_type'));?></td>
										</tr>
										<tr>
											<th>Starting Date</th>
											<td>
												<?php
												   $date = Session::get('semester_timestamp');
							                       $date = strtotime($date);
							                       $date = date('d/M/Y', $date);
							                       echo $date;
							                    ?>
											</td>
										</tr>
									</table>
        <?php
        }
}
else{
    echo "Temporary Problem, please try again after some time. . .";
}
?>
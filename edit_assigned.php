<?php 
require_once 'core/init.php';
if(!loggedIn()){
    die();
}
if(!Input::exists('get') || Input::get('cid')=='' || Input::get('did')=='' || Input::get('cs')==''){
    die();
}
else{
    $c = new Course();
    $course = $c->getAppointedInfo(Input::get('cid'), Input::get('did'), Input::get('cs'));
?>


<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/edit_assigned.js"></script>
<form id="edit_assigned" method="post">
	<legend>Edit Details</legend>
	<table class="table table-bordered table-striped">
		<tbody>
				<tr>
			        <th>Course Code</th>
			        <td><input type='hidden' name='course_code' value='<?php echo Input::get('cid'); ?>'><?php echo Input::get('cid'); ?></td>
			    </tr>
				<tr>    
			        <th>Course Name</th>
			        <td>
			        	<?php
		                    $cc = new Course();
		                    $cc->getInfobyId($course->course_code);
		                    echo $cc->getCourseName();
		                    unset($cc); 
	                     ?>
	                </td>
	            </tr>
				<tr>    
			        <th>Department</th>
			        <td>
						<input type="hidden" name="department" value="<?php echo Input::get('did'); ?>">
						<?php
						$dd = new Department();
						$dd->getInfo(Input::get('did'));
						echo $dd->getDepName();
						?>
					</td>
				</tr>
				<tr>	
			        <th>Semester</th>
			        <td><input type="hidden" name="semester" value="<?php echo Input::get('cs'); ?>"><?php echo Input::get('cs'); ?></td>
			    </tr>
				<tr>  
			        <th>Appointed Teacher</th>
			        <td>
						<select name="teacher" class="box dept_input">
						<option value="" selected>Teacher</option>
						<?php
				    		$t = new Teacher();
				    		$tt = $t->getAllTeachers();
				    		while($teacher = $tt->fetch_object()){
						?>
						<option value="<?php echo $teacher->teacher_id ?>" <?php echo (($course->teacher_id==$teacher->teacher_id)?'selected':''); ?>><?php echo $teacher->name; ?></option>
						<?php
							}
						?>
						</select>
					</td>
			
		    	</tr>
				<tr>	
					<td>
						<input type="submit" value=" &nbsp;Save&nbsp; " class="btn btn-success" name = "submit" />
					</td>
					<td>
						<input type="button" class="btn btn-danger" value="Cancel" onClick="save_edit_a()"; />
					</td>
			 	</tr>
				
			</tbody>
	</table>
</form>
<?php
}
?>
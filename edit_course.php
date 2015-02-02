<?php 
require_once 'core/init.php';
if(!loggedIn()){
	die();
}
if(!Input::exists('get')){
	die();
}
else{
	$c = new Course();
	$cc = $c->getInfobyId(Input::get('cid'));
?>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/edit_course.js"></script>
<form id="edit_course" method="post">
	<legend>Edit Details</legend>
	<table class="table table-bordered table-striped">
			<tbody>
				<tr>
					<th>Course Code</th>
					<td><input type='hidden' name='coursecode' value='<?php echo Input::get('cid'); ?>'><?php echo Input::get('cid'); ?></td>
				</tr>
				<tr>	
			        <th>Course Name</th>
			        <td><input type="text" id="course_code_name" name="coursename" placeholder="Course Name" value="<?php echo $c->getCourseName(); ?>" /></td>
			    </tr>
				<tr>    
			        <th>Department</th>
			        <td>
						<select name="department">
							<option value="">Department</option>
					
							<?php
								$dep = new Department();
								$departments = $dep->getAllDepartment();
								while($department = $departments->fetch_object()){
							?>
							<option value="<?php echo $department->dept_id; ?>" <?php echo (($c->getCourseDepartment()==$department->dept_id)?'selected':''); ?>><?php echo $department->name; ?></option>
							<?php
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
			        <th>Credit</th>
			        <td>
						<select name="credit" class="credit_sel">
							<option value="">Credits</option>
							<option value="1" <?php echo (($c->getCourseCredit()=='1')?'selected':''); ?>>1</option>
							<option value="2" <?php echo (($c->getCourseCredit()=='2')?'selected':''); ?>>2</option>
							<option value="3" <?php echo (($c->getCourseCredit()=='3')?'selected':''); ?>>3</option>
							<option value="4" <?php echo (($c->getCourseCredit()=='4')?'selected':''); ?>>4</option>
							<option value="5" <?php echo (($c->getCourseCredit()=='5')?'selected':''); ?>>5</option>
							<option value="6" <?php echo (($c->getCourseCredit()=='6')?'selected':''); ?>>6</option>
							<option value="7" <?php echo (($c->getCourseCredit()=='7')?'selected':''); ?>>7</option>
							<option value="8" <?php echo (($c->getCourseCredit()=='8')?'selected':''); ?>>8</option>
							<option value="9" <?php echo (($c->getCourseCredit()=='9')?'selected':''); ?>>9</option>
							<option value="10" <?php echo (($c->getCourseCredit()=='10')?'selected':''); ?>>10</option>
						</select>
					</td>
				</tr>
				<tr>	
					<td>
						<input type="submit" value=" &nbsp;Save&nbsp; " class="btn btn-success" name = "submit" />
					</td>
					<td>
						<input type="button" class="btn btn-danger" value="Cancel" onClick="save_edit_c()"; />
					</td>
			 	</tr>
				
			</tbody>
	</table>
</form>
<?php
}
?>
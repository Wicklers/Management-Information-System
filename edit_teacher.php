<?php 
require_once 'core/init.php';
if(!loggedIn()){
	die();
}
if(!Input::exists('get')){
	die();
}
else{
	$t = new Teacher();
	$tt = $t->getInfo(Input::get('tid'));
?>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/edit_teacher.js"></script>
<form id="edit_teacher" method="post">
	<legend>Edit Details</legend>
	<table class="table table-bordered table-striped">
			<tbody>
				<tr>
			        <th>Name</th>
			        <td><input type='hidden' name='t_id' value='<?php echo Input::get('tid'); ?>'>
						<input type="text" placeholder="Name of Teacher" class="" value="<?php echo $t->getName(); ?>" name="name"/>
					</td>
				</tr>
				<tr>
			        <th>Privilege</th>
			        <td>
						<select name="privilege">
							<option value="">Privilege</option>
							<option value="director" <?php echo (($t->getPrivilege()=='director')?'selected':''); ?>>Director</option>
							<option value="dean" <?php echo (($t->getPrivilege()=='dean')?'selected':''); ?>>Dean</option>
							<option value="hod" <?php echo (($t->getPrivilege()=='hod')?'selected':''); ?>>HOD</option>
							<option value="dupc" <?php echo (($t->getPrivilege()=='dupc')?'selected':''); ?>>DUPC</option>
							<option value="dppc" <?php echo (($t->getPrivilege()=='dppc')?'selected':''); ?>>DPPC</option>
							<option value="teacher" <?php echo (($t->getPrivilege()=='teacher')?'selected':''); ?>>Teacher</option>
						</select>
					</td>
				</tr>
				<tr>	
			        <th>Department</th>
			        <td>
						<select name="department">
							<option value="" selected>Department</option>
							<?php
								$dep = new Department();
								$departments = $dep->getAllDepartment();
								while($department = $departments->fetch_object()){
							?>
							<option value="<?php echo $department->dept_id; ?>" <?php echo (($t->getDep()==$department->dept_id)?'selected':''); ?>><?php echo $department->name; ?></option>
							<?php
								}
							?>
						</select>
					</td>
				</tr>
				<tr>	
			        <th>Email</th>
			        <td><input type="text" placeholder="Email" class="" value="<?php echo $t->getEmail(); ?>" name="email"/></td>
			    </tr>
				<tr>    
			        <th>Mobile</th>
			        <td><input type="text" placeholder="Mobile" class="" value="<?php echo $t->getMobile(); ?>" name="mobile"/></td>
			    </tr>
				<tr>    
			        <th>Approved</th>
			        <td>
						<select name="approved" class="">
							<option value="0" <?php echo (($t->getApproved()=='0')?'selected':''); ?>>Not Approved</option>
							<option value="1" <?php echo (($t->getApproved()=='1')?'selected':''); ?>>Approved</option>
						</select>
					</td>
				</tr>
				<tr>
			        <th>Blocked</th>
			        <td>
						<select name="blocked" class="">
							<option value="0" <?php echo (($t->getBlocked()=='0')?'selected':''); ?>>Not Blocked</option>
							<option value="1" <?php echo (($t->getBlocked()=='1')?'selected':''); ?>>Blocked</option>
						</select>
					</td>
				</tr>
				<tr>	
					<td>
						<input type="submit" value=" &nbsp;Save&nbsp; " class="btn btn-success" name = "submit" />
					</td>
					<td>
						<input type="button" class="btn btn-danger" value="Cancel" onClick="save_edit_t()"; />
					</td>
			 	</tr>
				
			</tbody>
	</table>

</form>
<?php
}
?>


<?php 
require_once 'core/init.php';
if(!loggedIn()){
	die();
}
if(!Input::exists('get')){
	die();
}
else{
	$dep = new Department();
	$departments = $dep->getInfo(Input::get('did'));
?>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/edit_department.js"></script>
<form id="edit_department" method="post">
	<legend>Edit Details</legend>
	<table class="table table-bordered table-striped">
		<tbody>
			<tr>
				<th>Department ID</th>
				<td><input type='hidden' name='id' value='<?php echo Input::get('did'); ?>'><?php echo Input::get('did'); ?></td>
			</tr>
			<tr>	
		        <th>Name</th>
		        <td><input type="text" placeholder="Name of Department" value="<?php echo $dep->getDepName(); ?>" name="name"/></td>
		    </tr>
			<tr>    
		        <th>No. of Course(s)</th>
		        <td>
				<?php 
					$cors = new Course();
					$courses = $cors->getInfobyDept(Input::get('did'));
					echo $courses->num_rows;
				?>	
				</td>
			</tr>
			<tr>	
		        <th>No. of Teacher(s)</th>
		        <td>
				<?php
					$t = new Teacher();
					$teachers = $t->getInfobyDept(Input::get('did'));
					echo $teachers->num_rows;
				?>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value=" &nbsp;Save&nbsp; " class="btn btn-success" name = "submit" />
					
				</td>	
		    	<td>
		    		<input type="button" class="btn btn-danger" value="Cancel" onClick="save_edit_dep()"; />
		    	</td>
			</tr>
		
		</tbody>
	</table>
</form>
<?php
}
?>
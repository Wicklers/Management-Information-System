<?php
require_once '../core/init.php';
if(!loggedIn()){
	die();
}
if(privilege()==NULL){
	die();
}
/*
if(!Input::exists('get')){
	
}
else{
	$dep = new Department();
	$departments = $dep->getInfo(Input::get('did'));
?>
<td><?php echo Input::get('did'); ?></td>
<td<?php echo $dep->getDepName(); ?></td>
<td>
<?php 
	$cors = new Course();
	$courses = $cors->getInfobyDept(Input::get('did'));
	echo $courses->num_rows;
?>
</td>
<td>
<?php
	$t = new Teacher();
	$teachers = $t->getInfobyDept(Input::get('did'));
	echo $teachers->num_rows;
						
?>
</td>
	<td>
		<button class="btn btn-default" onClick="edit_department_feild(<?php echo Input::get('id') . ',' . Input::get('did') ; ?>);" >Edit</button>
		<button class="btn btn-danger" onClick="delete_department(<?php echo Input::get('id') . ',' . Input::get('did') ; ?>)"; >Delete</button>
	</td>
<?php
}
*/
?>
  						 <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">List of all Departments</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Department ID</th>
                                                <th>Name</th>
                                                <th>No. of Course(s)</th>
                                                <th>No. of Teacher(s)</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
												$i=0;
												$dep = new Department();
												$departments = $dep->getAllDepartment();
												while($department = $departments->fetch_object()){
												$i++;	
											?>
                                            <tr id="<?php echo "department_row_id".$i; ?>">
                                                <td><?php echo $department->dept_id; ?></td>
                                                <td><?php echo $department->name; ?></td>
                                                <td><?php 
														$cors = new Course();
														$courses = $cors->getInfobyDept($department->dept_id);
														echo $courses->num_rows;
													?>
												</td>
                                                <td><?php
														$t = new Teacher();
														$teachers = $t->getInfobyDept($department->dept_id);
														echo $teachers->num_rows;
													?>
												</td>
												<td><button class="btn btn-default" onClick="edit_department_feild(<?php echo $i . ',' . $department->dept_id ; ?>);" > &nbsp; Edit &nbsp; </button>&nbsp;
													<button class="btn btn-danger" onClick="delete_department(<?php echo $i . ',' . $department->dept_id ; ?>)"; >Delete</button>
												</td>
                                            </tr>
                                            <?php
                                            	}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Department ID</th>
                                                <th>Name</th>
                                                <th>No. of Course(s)</th>
                                                <th>No. of Teacher(s)</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                     <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
            </script>
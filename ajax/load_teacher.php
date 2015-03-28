<?php
require_once '../core/init.php';
if(!loggedIn()){
	die();
}
if(privilege()==NULL){
	die();
}
?>
                    <div class="row" id="content_area">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">List of all Teachers</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Privilege</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Approved</th>
                                                <th>Blocked</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
													$i=0;
													$t = new Teacher();
													$teachers = $t->getAllTeachers();
													while($teacher = $teachers->fetch_object()){
														if(Session::exists('teacher_id') && Session::get('teacher_id')==$teacher->teacher_id){
															$i++;
														}
														else{
															$i++;
											?>
                                            <tr id="<?php echo "teacher_row_id".$i; ?>">
                                                <td><?php echo $teacher->name; ?></td>
                                                <td><?php echo strtoupper($teacher->privilege); if($teacher->privilege=='dean'){echo ' ACADEMICS';}?></td>
                                                <td><?php 
														$d = new Department();
														$di = $d->getInfo($teacher->dept_id);
														echo $d->getDepName();
													?>
												</td>
												<td><?php echo $teacher->email; ?></td>
												<td><?php echo $teacher->mobile; ?></td>
                                                <td><?php echo (($teacher->approved)?'Approved':'Not Approved'); ?></td>
                                                <td><?php echo (($teacher->blocked)?'Blocked':'-'); ?></td>
												<td><button class="btn btn-default" onClick="edit_teacher_feild(<?php echo $i . ',' . $teacher->teacher_id ; ?>);" >&nbsp;&nbsp; &nbsp;Edit&nbsp; &nbsp;&nbsp;</button>
													<button class="btn btn-danger" onClick="delete_teacher(<?php echo $i . ',' . $teacher->teacher_id.',\''.$teacher->privilege . '\''; ?>)"; >Remove</button>
												</td>
                                            </tr>
                                            <?php
                                            		}
                                            	}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Privilege</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Approved</th>
                                                <th>Blocked</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
				<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
            </script>

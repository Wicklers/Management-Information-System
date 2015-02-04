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
                                    <h3 class="box-title">List of all Registered Students</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Scholar Number</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Sem</th>
                                                <th>Mobile</th>
                                                <th>Parent's<br/>Mobile</th>
                                                <th>Regular <br/> Courses</th>
                                                <th>Load <br/> Courses</th>
                                                <th>Total Credit Scored</th>
                                                <th>Total Credit Point</th>
                                                <th>Home<br/>Address</th>
                                                <th>Hostel<br/>Address</th>
                                                <th>Mobile<br/>Verified</th>
                                                <th>Approved</th>
                                                <th>Blocked</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
													$i=0;
													$t = new Student();
													$students = $t->getAllStudents();
													while($student = $students->fetch_object()){
														
											?>
                                            <tr id="<?php echo "student_row_id".$i; ?>">
                                                <td><?php echo $student->scholar_no; ?></td>
                                                <td><?php echo $student->name; ?></td>
                                                <td><?php 
														$d = new Department();
														$di = $d->getInfo($student->department);
														echo $d->getDepName();
													?>
												</td>
												<td><?php echo $student->semester; ?></td>
												<td><?php echo $student->mobile; ?></td>
												<td><?php echo $student->parents_mobile; ?></td>
												<td><?php
														$courses=str_replace(',', '<br/>', $student->courses);
														echo $courses; 
												?></td>
												<td><?php
														$courses=str_replace(',', '<br/>', $student->courses_load);
														echo $courses; 
												?></td>
												<td><?php echo $student->total_score; ?></td>
												<td><?php echo $student->total_max_score; ?></td>
												<td><?php echo $student->home_address; ?></td>
												<td><?php echo $student->hostel_address; ?></td>
												<td><?php echo (($student->mobile_verified)?'Yes':'No'); ?></td>
                                                <td><?php echo (($student->approved)?'Approved':'Not Approved'); ?></td>
                                                <td><?php echo (($student->blocked)?'Blocked':'-'); ?></td>
												<td><button class="btn btn-danger" onClick="edit_student_feild(<?php echo $i . ',\'' . $student->scholar_no . '\''; ?>);" >&nbsp;Edit&nbsp;</button>
												</td>
                                            </tr>
                                            <?php
                                            	}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Scholar Number</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Sem</th>
                                                <th>Mobile</th>
                                                <th>Parent's<br/>Mobile</th>
                                                <th>Regular <br/> Courses</th>
                                                <th>Load <br/> Courses</th>
                                                <th>Total Credit Scored</th>
                                                <th>Total Credit Point</th>
                                                <th>Home<br/>Address</th>
                                                <th>Hostel<br/>Address</th>
                                                <th>Mobile<br/>Verified</th>
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

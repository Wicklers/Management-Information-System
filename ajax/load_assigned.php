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
                                    <h3 class="box-title">List of all Courses with respective Teacher</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Appointed Teacher</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
	                                        	<?php
														$i=0;
														$c = new Course();
											            $courses = $c->getAllAppointed();
											            while(!empty($courses) && $course = $courses->fetch_object()){
											            	$i++;
												?>
                                            <tr id="<?php echo "assigned_row_id".$i; ?>">
                                                <td><?php echo $course->course_code; ?></td>
                                                <td>
													<?php
                                                    $cc = new Course();
                                                    $cc->getInfobyId($course->course_code);
                                                    echo $cc->getCourseName();
                                                    unset($cc);
                                                    
                                                     ?>
												</td>
                                                <td><?php 
														$d = new Department();
														$d->getInfo($course->course_dep);
														echo $d->getDepName();
														unset($d);
													?>
												</td>
												<td><?php echo $course->course_sem; ?></td>
												<td><?php 
														$t = new Teacher();
														$t->getInfo($course->teacher_id);
														echo $t->getName();
														unset($t);
													?>
												</td>
												<td><button class="btn btn-default" onClick="edit_assigned_feild(<?php echo $i . ',\'' . $course->course_code. '\',' . $course->course_dep. ',' . $course->course_sem ; ?>);" >&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
													<button class="btn btn-danger"  onClick="delete_assigned(<?php echo $i . ',\'' . $course->course_code. '\',' . $course->course_dep. ',' . $course->course_sem ; ?>);" >Remove</button>
												</td>
                                            </tr>
                                            <?php
                                            		}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Appointed Teacher</th>
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
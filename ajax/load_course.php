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
                                    <h3 class="box-title">List of all Courses</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Credit Point</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
	                                        	<?php
														$i=0;
														$cors = new Course();
														$courses = $cors->getAllCourses();
														while($course = $courses->fetch_object()){
															$i++;
												?>
                                            <tr id="<?php echo "course_row_id".$i; ?>">
                                                <td><?php echo $course->course_id; ?></td>
                                                <td><?php echo $course->course_name; ?></td>
                                                <td><?php 
														$d = new Department();
														$d->getInfo($course->course_department);
														echo $d->getDepName();
													?>
												</td>
												<td><?php echo $course->course_credit; ?></td>
												<td><button class="btn btn-default" onClick="edit_course_feild(<?php echo $i . ',\'' . $course->course_id . '\'' ; ?>);" >&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
													<button class="btn btn-danger"  onClick="delete_course(<?php echo $i . ',\'' . $course->course_id . '\'' ; ?>);" >Delete</button>
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
                                                <th>Credit Point</th>
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
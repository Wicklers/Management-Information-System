<?php
if(!loggedIn()){
	die();
	exit();
}
?>	             
	             
	             
	             <!-- Content Header (Page header) -->
	             <!-- DATA TABLES -->
        		<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
                <section class="content-header">
                    <h1>
                        Courses
                        <small>View all courses</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Courses</a></li>
                        <li class="active">View all courses</li>
                    </ol>
                </section>

                <!-- Main content -->
                
                <section class="content">
                	<div id="update">
                	
                	</div>
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

                </section><!-- /.content -->
		<!-- Edit modal -->
		<div id="editModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        	<h4 class="modal-title" id="editArea">Update here</h4>
		      	</div>
		    </div>
		  </div>
		</div>
		<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!--Page Script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
            
            function edit_course_feild($id,$c_id){
				if(confirm('Are you sure, you want to edit this course\'s details?')){
					$('#editModal').modal();
					$('#editArea').load('edit_course.php?id='+$id+'&cid='+$c_id);
				}
			}
			
			function save_edit_c(){
				$('#editModal').modal('hide');
				$('#content_area').load('ajax/load_course.php');
			}
	
			function delete_course($id,$c_id){
				if(confirm('Are you sure, you want to delete this course?')){
					$('#update').load('ajax/delete_course.php?id='+$id+'&cid='+$c_id);
			
				}
				
			}
            
        </script>
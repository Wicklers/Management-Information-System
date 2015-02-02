<?php
require_once '../core/init.php';
if(!loggedIn() || privilege()==NULL || privilege()=='admin'){
	die();
}
?>
<!-- DATA TABLES -->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<?php 
	$s = new Student();
	$s->getInfo(Session::get('sn'));
?>
				<section class="content-header">
                    <h1>
                        Attendance System
                        <small>View attendance</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Attendance System</a></li>
                        <li class="active">View attendance</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="row">
                		<div class="col-md-1">
                			&nbsp;
                		</div>
                		<div class="col-md-10">
                			
					<div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Regular Courses</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Classes Attended</th>
                                                <th>Total Classes</th>
                                                <th>Attendance Percentage*</th>
                                                <th>Last Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		$courses = $s->getCourses();
                                        		$courses = explode(',',$courses);
                                        		foreach($courses as $course){
                                        	?>
                                        	<tr>
                                        	<td><?php echo $course; ?></td>
                                        	<td>
                                        		<?php 
                                        			$c = new Course();
                                        			$c->getInfobyId($course);
                                        			echo $c->getCourseName();
                                        			unset($c);
                                        			$a = new Attendance();
                                        			$view = $a->getEntry(Session::get('sn'), $course);
                                        			if(empty($view)){
                                        				$ca = '-';
                                        				$tc = '-';
                                        				$p = '-';
                                        				$lu = '-';
                                        			}
                                        			else{
														$view = $view->fetch_object();
                                        				$ca = $view->classes_attended;
                                        				$tc = $view->classes_total;
                                        				$p = $view->percentage.'%';
                                        				$lu = $view->timestamp;
                                        				$lu = strtotime($lu);
                                        				$lu = date('d/M/Y H:i', $lu);
                                        				unset($view);
                                        				unset($a);
                                        			}
                                        		?>
                                        	</td>
                                        	<td><?php echo $ca; ?></td>
                                        	<td><?php echo $tc; ?></td>
                                        	<td><?php echo $p; ?></td>
                                        	<td><?php echo $lu; ?></td>
                                        	</tr>
                                        	<?php
                                        		}
                                        		
                                        	?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                	*This system ensures 'F' grade in the subject if it has attendance below 75%.<br/>
                                	'-' implies teacher has not yet updated attendance.
                                </div><!-- ./box-footer -->
                            </div><!-- /.box -->
				
                		</div>
                		<div class="col-md-1">
                			&nbsp;
                		</div>
                	</div>
                </section>
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!--  Main javascript files -->
        <script type="text/javascript">
            $(function() {
                $("#table1").dataTable();
            });
        </script>
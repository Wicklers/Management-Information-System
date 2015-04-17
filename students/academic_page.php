<?php
if(!loggedIn() || privilege()==NULL){
	Redirect::to('logout.php');
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
                        Academics
                        <small>Your Academic Details </small>
                        <b><small> > Current Semester : <?php echo $s->getSemester(); ?></small></b>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><a href="#">Academia</a></li>
                    </ol>
</section>

<!-- Main content -->

<section class="content">
	<div class="row">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Regular Courses</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Class Test 1</th>
                                                <th>Class Test 2</th>
                                                <th>Internal Assesment</th>
                                                <th>Mid-Sem</th>
                                                <th>End-Sem</th>
                                                <th>Grade</th>
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
                                        			$m = new Marks();
                                        			$marks = $m->getMarks(Session::get('sn'), $course, '*');
                                        			if($marks==''){
                                        				$ct1 = '-';
                                        				$ct2 = '-';
                                        				$ia = '-';
                                        				$ms = '-';
                                        				$es = '-';
                                        				$g = '-';
                                        			}
                                        			else{
														$marks = $marks->fetch_object();
                                        				$ct1 = $marks->ct1;
                                        				$ct2 = $marks->ct2;
                                        				$ia = $marks->ct3;
                                        				$ms = $marks->midsem;
                                        				$es = $marks->endsem;
                                        				$sem = new Semester();
                                        				$g = (($marks->pointer!=NULL && $sem->isResultPublished())?$m->getGradeFromPointer($marks->pointer):'-');
                                        				unset($marks);
                                        				unset($m);
                                        				unset($sem);
                                        			}
                                        		?>
                                        	</td>
                                        	<td><?php echo ($ct1!=NULL)?($ct1==-200?'AB':$ct1):'-'; ?></td>
                                        	<td><?php echo ($ct2!=NULL)?($ct2==-200?'AB':$ct2):'-'; ?></td>
                                        	<td><?php echo ($ia!=NULL)?($ia==-200?'AB':$ia):'-'; ?></td>
                                        	<td><?php echo ($ms!=NULL)?($ms==-200?'AB':$ms):'-'; ?></td>
                                        	<td><?php echo ($es!=NULL)?($es==-200?'AB':$es):'-'; ?></td>
                                        	<td><?php echo $g; ?></td>
                                        	</tr>
                                        	<?php
                                        		}
                                        		
                                        	?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
				</div>
			</div>
			<?php if($s->getCoursesLoad()!='') {
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="box box-danger">
                                <div class="box-header">
                                    <h3 class="box-title">Load Courses</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Class Test 1</th>
                                                <th>Class Test 2</th>
                                                <th>Internal Assesment</th>
                                                <th>Mid-Sem</th>
                                                <th>End-Sem</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		$courses = $s->getCoursesLoad();
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
                                        			$m = new Marks();
                                        			$marks = $m->getMarksLoad(Session::get('sn'), $course, '*');
                                        			if($marks==''){
                                        				$ct1 = '-';
                                        				$ct2 = '-';
                                        				$ia = '-';
                                        				$ms = '-';
                                        				$es = '-';
                                        				$g = '-';
                                        			}
                                        			else{
														$marks = $marks->fetch_object();
                                        				$ct1 = $marks->ct1;
                                        				$ct2 = $marks->ct2;
                                        				$ia = $marks->ct3;
                                        				$ms = $marks->midsem;
                                        				$es = $marks->endsem;
                                        				$g = ($marks->pointer!=NULL?$m->getGradeFromPointer($marks->pointer):'-');
                                        				unset($marks);
                                        				unset($m);
                                        			}
                                        		?>
                                        	</td>
                                        	<td><?php echo ($ct1!=NULL)?($ct1==-200?'AB':$ct1):'-'; ?></td>
                                        	<td><?php echo ($ct2!=NULL)?($ct2==-200?'AB':$ct2):'-'; ?></td>
                                        	<td><?php echo ($ia!=NULL)?($ia==-200?'AB':$ia):'-'; ?></td>
                                        	<td><?php echo ($ms!=NULL)?($ms==-200?'AB':$ms):'-'; ?></td>
                                        	<td><?php echo ($es!=NULL)?($es==-200?'AB':$es):'-'; ?></td>
                                        	<td><?php echo $g; ?></td>
                                        	</tr>
                                        	<?php
                                        		}
                                        		
                                        	?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
				</div>
				
			</div>
			<?php } ?>
		</div>
		<div class="col-md-2">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Performance Index</h3>
				</div> <!-- ./box-header -->
				<div class="box-body table-responsive" id="semester_details">
					<table class="table">
						<tr>
							<th>CPI</th>
							<td><?php echo round($s->getCPI(),2);?></td>
						</tr>
						<tr>
							<th>SPI*</th>
							<td><?php echo round($s->getSPI(),2); ?></td>
						</tr>
					</table>
				</div> <!-- ./box-body -->
				<div class="box-footer">
					*SPI is of most recent semester result. <br/> 
				</div>
			</div>
		</div>
	</div>
						
</section><!-- /.content -->

		
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
            $(function() {
                $("#table2").dataTable();
            });
            
        </script>

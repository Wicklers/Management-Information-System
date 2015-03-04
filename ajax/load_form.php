<?php 
require_once '../core/init.php';
if(Input::exists('get') || !Input::exists() || privilege()==NULL){
	die();
}
	$type = Input::get('examtype');
	$t = new Teacher();
	$tt = $t->getInfo(Session::get('teacher_id'));
			if(!Input::get('course_id')){
				?>
				<div class="box box-primary">
	
					<div class="box-header">
						<h3 class="box-title">Please Select Course</h3>
					</div> <!-- ./box header -->
				</div>
				<?php
				die();
			}
			if(!Input::get('examtype')){
				?>
				<div class="box box-primary">
	
					<div class="box-header">
						<h3 class="box-title">Please Select Exam Type</h3>
					</div> <!-- ./box header -->
				</div>
				<?php
				die();
			}
			$m=new Marks();
			$lastdate = $m->getLastDate(Input::get('examtype'))->fetch_object()->date;
			
			$today = date('Y-m-d');
			if($today>=$lastdate){
				
				$date = date_create($lastdate);
				?>
				<div class="box box-primary">
	
					<div class="box-header">
						<h3 class="box-title"><?php echo "Last Date for ".strtoupper(Input::get('examtype'))." was ".date_format($date, 'd-M-Y').""; ?></h3>
					</div> <!-- ./box header -->
				</div>
				<?php
				die();
			}
			else
			{
				$input = explode(',', Input::get('course_id'));
				$c_dep = $input[1];
                $c_code = $input[0];
				$stud = new Student();
                $studs = $stud->CourseDepStudents($c_dep, $c_code);
                if($studs==''){
                	?>
				<div class="box box-primary">
	
					<div class="box-header">
						<h3 class="box-title"><?php echo "No students are currently enrolled for this course."; ?></h3>
					</div> <!-- ./box header -->
				</div>
				<?php
                }
                else{
	?>
<!-- DATA TABLES FOR REGULAR STUDENTS-->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<form id="savemarks" role="form">
<input type="hidden" value="<?php echo $c_code; ?>" name="c_code" />
<input type="hidden" value="<?php echo $c_dep; ?>" name="c_dep" />
<input type="hidden" value="<?php echo Input::get('examtype'); ?>" name="examtype" />
<div class="box box-primary">
	
	<div class="box-header">
		<h3 class="box-title">Fill marks for regular students</h3>
		<button type="submit" class="btn btn-primary btn-lg pull-right" name='submit'><i class="fa fa-save"></i>&nbsp; &nbsp;Save &nbsp; &nbsp;</button>
	</div> <!-- ./box header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-hover">
        	<thead>
            	<tr>
                	<th>#</th>
                    <th>Scholar No.</th>
                    <th><?php switch(Input::get('examtype')){
                    	case 'ct1':
                    		echo "Class Test-1 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct2':
                    		echo "Class Test-2 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct3':
                    		echo "Internal Assessment <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'midsem':
                    		echo "Mid-Semester <i>(Max Marks : 30)</i>";
                    		$max = "30";
                    		break;
                    	case 'endsem':
                    		echo "End-Semester <i>(Max Marks : 50)</i>";
                    		$max = "50";
                    		break;
                    } ?>
                    
                    
                    </th>
                 </tr>
            </thead> 
            <tbody>
				<?php 
			    	$j=0;
					while($students = $studs->fetch_object())
					{
						$mmm = new Marks();
						$saved_m = $mmm->getMarks($students->scholar_no,$c_code, $type);
					               
						if(!empty($saved_m) && $saved_m->num_rows){
							$marks = $saved_m->fetch_object()->$type;
						}
						else{
							$marks = 0.0;
					    }
						
				?>
				<tr>
					<th><?php echo $j+1; ?></th>
					<th><input type="hidden" name="scholar_number<?php echo $j+1 ; ?>" value="<?php echo $students->scholar_no; ?>" /><?php echo $students->scholar_no; ?></th>
					<td><input class="form-control" name="marks<?php echo $j+1 ; ?>" type="number" value=<?php echo $marks; ?> min=0 max=<?php echo $max; ?> step="0.01" required /></td>		
				</tr>
					<?php 
							$j++;
								}
							
					?>    	
            </tbody>
            <tfoot>
            	<tr>
                	<th>#</th>
                    <th>Scholar No.</th>
		    <th><?php switch(Input::get('examtype')){
                    	case 'ct1':
                    		echo "Class Test-1 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct2':
                    		echo "Class Test-2 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct3':
                    		echo "Internal Assessment <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'midsem':
                    		echo "Mid-Semester <i>(Max Marks : 30)</i>";
                    		$max = "30";
                    		break;
                    	case 'endsem':
                    		echo "End-Semester <i>(Max Marks : 50)</i>";
                    		$max = "50";
                    		break;
                    } ?>
                    
                    
                    </th>
                 </tr>
            </tfoot>
        </table>
	</div> <!-- ./box-body -->
</form>
</div><?php
			}
			$input = explode(',', Input::get('course_id'));
			$c_dep = $input[1];
			$c_code = $input[0];
			$stud = new Student();
			$studs = $stud->CourseDepStudentsLoad($c_dep, $c_code);
			if($studs==''){
				?>
							<div class="box box-primary">
				
								<div class="box-header">
									<h3 class="box-title"><?php echo "No students have currently taken this course as load subject."; ?></h3>
								</div> <!-- ./box header -->
							</div>
							<?php
			                }
			else{
	?>
<!-- DATA TABLES FOR LOAD STUDENTS-->
<form id="savemarks_load" role="form">
<input type="hidden" value="<?php echo $c_code; ?>" name="c_code" />
<input type="hidden" value="<?php echo $c_dep; ?>" name="c_dep" />
<input type="hidden" value="<?php echo Input::get('examtype'); ?>" name="examtype" />
<div class="box box-primary">
	
	<div class="box-header">
		<h3 class="box-title">Fill marks for load subject students</h3>
		<button type="submit" class="btn btn-primary btn-lg pull-right" name='submit'><i class="fa fa-save"></i>&nbsp; &nbsp;Save &nbsp; &nbsp;</button>
	</div> <!-- ./box header -->
	<div class="box-body table-responsive">
		<table id="example2" class="table table-bordered table-hover">
        	<thead>
            	<tr>
                	<th>#</th>
                    <th>Scholar No.</th>
                    <th><?php switch(Input::get('examtype')){
                    	case 'ct1':
                    		echo "Class Test-1 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct2':
                    		echo "Class Test-2 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct3':
                    		echo "Internal Assessment <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'midsem':
                    		echo "Mid-Semester <i>(Max Marks : 30)</i>";
                    		$max = "30";
                    		break;
                    	case 'endsem':
                    		echo "End-Semester <i>(Max Marks : 50)</i>";
                    		$max = "50";
                    		break;
                    } ?>
                    
                    
                    </th>
                 </tr>
            </thead>
            <tbody>
				<?php 
			    	$j=0;
					while($students = $studs->fetch_object())
					{
						$mmm = new Marks();
						$saved_m = $mmm->getMarksLoad($students->scholar_no,$c_code, $type);
					               
						if(!empty($saved_m) && $saved_m->num_rows){
							$marks = $saved_m->fetch_object()->$type;
						}
						else{
							$marks = 0.0;
					    }
						
				?>
				<tr>
					<th><?php echo $j+1; ?></th>
					<th><input type="hidden" name="scholar_number<?php echo $j+1 ; ?>" value="<?php echo $students->scholar_no; ?>" /><?php echo $students->scholar_no; ?></th>
					<td><input class="form-control" name="marks<?php echo $j+1 ; ?>" type="number" value=<?php echo $marks; ?> min=0 max=<?php echo $max; ?> step="0.01" required/></td>		
				</tr>
					<?php 
							$j++;
								}
							
					?>    	
            </tbody>
            <tfoot>
            	<tr>
                	<th>#</th>
                    <th>Scholar No.</th>
		    <th><?php switch(Input::get('examtype')){
                    	case 'ct1':
                    		echo "Class Test-1 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct2':
                    		echo "Class Test-2 <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'ct3':
                    		echo "Internal Assessment <i>(Max Marks : 10)</i>";
                    		$max = "10";
                    		break;
                    	case 'midsem':
                    		echo "Mid-Semester <i>(Max Marks : 30)</i>";
                    		$max = "30";
                    		break;
                    	case 'endsem':
                    		echo "End-Semester <i>(Max Marks : 50)</i>";
                    		$max = "50";
                    		break;
                    } ?>
                    
                    
                    </th>
                 </tr>
            </tfoot>
        </table>
	</div> <!-- ./box-body -->
</div>
</form>
<?php }
?>
		<!-- DATA TABLES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		
		<script src="js/save_marks.js"></script>
		<!-- Page Script -->
		<script type="text/javascript">
			$(function() {
                $("#example1").dataTable({
		    "iDisplayLength": 10,
		    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
		    });
                $("#example2").dataTable({
		    "iDisplayLength": 10,
		    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
		    });
            });
		</script>
	<?php 
			} 
	
	?>


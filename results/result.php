<?php
require_once '../core/init.php';
if(!loggedIn()){
    die();
	exit();
}
$m = new Marks();
$mar = $m->getMarksofAll($var[1],$var[0],'*');
$mar_load = $m->getMarksofAllLoad($var[1],$var[0],'*');
?>
<!-- DATA TABLES -->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-5">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid box-primary">
				<div class="box-header">
	            	<h3 class="box-title">Pie Representation</h3>
	                <div class="box-tools pull-right">
	                	<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
	        	</div>
	        	<div class="box-body">
	        		<?php
			  			$token=Token::generate();
					?>
					<img src="results/result_pie.php?cid=<?php echo $var[0]; ?>&did=<?php echo $var[1]; ?>&token=<?php echo $token; ?>" />
	        	</div>
			
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid box-primary">
				<div class="box-header">
	            	<h3 class="box-title">Graph Representation</h3>
	                <div class="box-tools pull-right">
	                	<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
	        	</div>
	        	<div class="box-body">
					<img src="results/result_spline.php?cid=<?php echo $var[0]; ?>&did=<?php echo $var[1]; ?>&token=<?php echo $token; ?>" />
	        	</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php
				$cid=$var[0];
				$dep=$var[1];
				$gmarks = new Marks();				
				$scale = $gmarks->getGradeScale($cid,$dep);
				$grade_set = explode(',',$scale);
			?>

			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">Grading Scale</h3>
					<div class="box-tools pull-right">
	                	<button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
				</div> <!-- /.box header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>Grade</th>
							<th>From</th>
							<th>To</th>
							
						</tr>
						
						<tr>	
							<th>AA</th>
							<td><?php echo isset($grade_set[1])?$grade_set[1]:'' ; ?></td>
							<td>100</td>	
						</tr>
						<tr>	
							<th>AB</th>
							<td><?php echo isset($grade_set[3])?$grade_set[3]:'' ; ?></td>
							<td><?php echo isset($grade_set[2])?$grade_set[2]:'' ; ?></td>	
						</tr>
						<tr>	
							<th>BB</th>
							<td><?php echo isset($grade_set[5])?$grade_set[5]:'' ; ?></td>
							<td><?php echo isset($grade_set[4])?$grade_set[4]:'' ; ?></td>	
						</tr>
						<tr>	
							<th>BC</th>
							<td><?php echo isset($grade_set[7])?$grade_set[7]:'' ; ?></td>
							<td><?php echo isset($grade_set[6])?$grade_set[6]:'' ; ?></td>	
						</tr>
						<tr>	
							<th>CC</th>
							<td><?php echo isset($grade_set[9])?$grade_set[9]:'' ; ?></td>
							<td><?php echo isset($grade_set[8])?$grade_set[8]:'' ; ?></td>	
						</tr>
						<tr>	
							<th>CD</th>
							<td><?php echo isset($grade_set[11])?$grade_set[11]:'' ; ?></td>
							<td><?php echo isset($grade_set[10])?$grade_set[10]:'' ; ?></td>	
						</tr>
						<tr>	
							<th>DD</th>
							<td><?php echo isset($grade_set[13])?$grade_set[13]:'' ; ?></td>
							<td><?php echo isset($grade_set[12])?$grade_set[12]:'' ; ?></td>	
						</tr>
						<tr>	
							<th>FF</th>
							<td>0</td>
							<td><?php echo isset($grade_set[13])?$grade_set[13]-1:'' ; ?></td>	
						</tr>
						
					</table>
				</div> <!-- /.box body -->
				</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">Sessional Formula</h3>
					<div class="box-tools pull-right">
	                	<button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
				</div> <!-- /.box header -->
				<div class="box-body">
					<h3><strong>
					 <?php 		
					 			unset($gmarks);
								$marks = new Marks();
					 			$sf = $marks->getSessionalFormula('',$cid,$dep);
	                           	if($sf->num_rows){
	                               $formula = $sf->fetch_object()->formula;
	                           	}else{
	                               $formula=1;
	                           	}
							   
							   switch($formula){
							   		case 1:
										echo 'Highest of Two Class Tests + Internal Assessment';
										break;
									case 2:
										echo 'Average of Two Class Tests + Internal Assessment';
										break;
									default:
										echo 'Highest of Two Class Tests + Internal Assessment';
										break;
							   }
					?>
					</strong><h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">Approval Status</h3>
					<div class="box-tools pull-right">
	                	<button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
				</div> <!-- /.box header -->
				<div class="box-body">
					<h3><strong>
					<?php
						$a = new Approval();
						$b = $a->statusApproval($cid, $dep);
						if($b->num_rows){
	                    	$status = $b->fetch_object()->status_level;
	                    }else{
	                   	    $status=-1;
	                   }
						switch($status){
							case -1:
								echo "Not yet approved by you for result.";
								break;
							case 0 :
								echo "Approved by course teacher for result.";
								break;
							case 1 :
								echo "Approved by 1 DUPC/DPPC member for result.";
								break;
							case 2 :
								echo "Approved by 2 DUPC/DPPC member for result.";
								break;
							case 3 :
								echo "Approved by 3 DUPC/DPPC member for result.";
							break;
							case 4 :
								echo "Approved by HOD for result.";
								break;
							case 5 :
								echo "Approved by DEAN for result.";
								break;
							case -1 :
								echo "Result in rejection status.";
								break;
							case -2 :
								echo "Not yet approved by you.";
								break;
							   }
					?></h3></strong>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-7">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid box-success">
				<div class="box-header">
	            	<h3 class="box-title">Marks sheet for regular students</h3>
	                <div class="box-tools pull-right">
	                	<button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
	        	</div>
	        	<div class="box-body">
					<table id="example1" class="table table-bordered table-hover table-condensed" border="1px">
						<thead>
							<tr>
								<th>#</th>
								<th>Scholar No.</th>
								<th>Sessional</th>
								<th>Mid Sem</th>
								<th>End Sem</th>
								<th>Total</th>
								<th>Grade</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							     $i=1;
								while(!empty($mar) && $row = $mar->fetch_object()){
									
								?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row->sch_no; ?></td>
								<td><?php echo $row->sessional; ?></td>
								<td><?php echo ($row->midsem==-200?'AB':$row->midsem); ?></td>
								<td><?php echo ($row->endsem==-200?'AB':$row->endsem); ?></td>
								<td><?php echo ($row->sessional+($row->midsem==-200?0:$row->midsem)+($row->endsem==-200?0:$row->endsem)); ?></td>
								<td><?php echo $m->getGradeFromPointer($row->pointer); ?></td>
							</tr>
							<?php
							     
								}
								?>
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Scholar No.</th>
								<th>Sessional</th>
								<th>Mid Sem</th>
								<th>End Sem</th>
								<th>Total</th>
								<th>Grade</th>
							</tr>
						</tfoot>
					</table>		
	        	</div>
	        </div>
			
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid box-success">
				<div class="box-header">
	            	<h3 class="box-title">Marks sheet for load subject students</h3>
	                <div class="box-tools pull-right">
	                	<button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                </div>
	        	</div>
	        	<div class="box-body">
					<table id="example2" class="table table-bordered table-hover table-condensed" border="1px">
						<thead>
							<tr>
								<th>#</th>
								<th>Scholar No.</th>
								<th>Sessional</th>
								<th>Mid Sem</th>
								<th>End Sem</th>
								<th>Total</th>
								<th>Grade</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							     $i=1;
								while(!empty($mar_load) && $row = $mar_load->fetch_object()){
									
								?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row->sch_no; ?></td>
								<td><?php echo $row->sessional; ?></td>
								<td><?php echo ($row->midsem==-200?'AB':$row->midsem); ?></td>
								<td><?php echo ($row->endsem==-200?'AB':$row->endsem); ?></td>
								<td><?php echo ($row->sessional+($row->midsem==-200?0:$row->midsem)+($row->endsem==-200?0:$row->endsem)); ?></td>
								<td><?php echo $m->getGradeFromPointer($row->pointer); ?></td>
							</tr>
							<?php
							     
								}
								?>
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Scholar No.</th>
								<th>Sessional</th>
								<th>Mid Sem</th>
								<th>End Sem</th>
								<th>Total</th>
								<th>Grade</th>
							</tr>
						</tfoot>
					</table>		
	        	</div>
	        </div>
			
		</div>
	</div>
	
</div>
</div>


		<!-- DATA TABLES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
		<!--Page Script -->
		<script type="text/javascript">
			$(function() {
                $(function() {
                $("#example1").dataTable({
		    "iDisplayLength": 200,
		    "aLengthMenu": [[-1], ["All"]]
		    });
                $("#example2").dataTable({
		    "iDisplayLength": 200,
		    "aLengthMenu": [[-1], ["All"]]
		    });
            });
            });
            $(".collapsed").click();
		</script>

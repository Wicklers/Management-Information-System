<?php 
require_once 'core/init.php';
if(!loggedIn() || !Input::exists('get')){
	die();
	exit();
}	
	$cid_dep = explode(',',Input::get('id'));
	$cid=$cid_dep[0];
	$dep=$cid_dep[1];
	$gmarks = new Marks();				
	$scale = $gmarks->getGradeScale($cid,$dep);
	$grade_set = explode(',',$scale);
?>

<div class="box box-default" id="grade_scale">
	<div class="box-header">
		<h3 class="box-title">Grading Scale</h3>
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
	<div class="box-footer">
		<button type="button" class="btn btn-primary" onclick="load_table('<?php echo "set_grade_table.php?id=".Input::get('id'); ?>');" >Edit</button></td>
	</div>



</div>

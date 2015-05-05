<?php 
require_once 'core/init.php';
if(!loggedIn()){
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
		<form  role="form" id="grade_scale">
			<input class="form-control" type="hidden" name="tid" value="<?php echo (Session::get('teacher_id')); ?>" />
			<input class="form-control" type="hidden" name="cid" value="<?php echo $cid; ?>" />
			<input class="form-control" type="hidden" name="dep" value="<?php echo $dep; ?>" />
		<table class="table table-hover">
			<tr>
				<th>Grade</th>
				<th>From</th>
				<th>To</th>
				
			</tr>
			
			<tr>	
				<th>AA</th>
				<td class="_a"><input class="form-control" name="from_aa"  onkeyup="changefrom('a',this.value);"  type="text" value="<?php echo isset($grade_set[1])?$grade_set[1]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" title='Must contain digits only' /></td>
				<td class=" b"><input class="form-control" name="to_aa" id="2"   type="text" min=0 max=100 required pattern="[0-9]{1,3}" /></td>	
			</tr>
			<tr>	
				<th>AB</th>
				<td class="_b"><input class="form-control" name="from_ab"  onkeyup="changefrom('b',this.value);"	type="text" value="<?php echo isset($grade_set[3])?$grade_set[3]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>									
				<td class="a_"><input class="form-control" name="to_ab" id="3"  onkeyup="changeto('a',this.value);"  type="text" value="<?php echo isset($grade_set[2])?$grade_set[2]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>		
			</tr>
			<tr>	
				<th>BB</th>
				<td class="_c"><input class="form-control" name="from_ba"  onkeyup="changefrom('c',this.value);"	type="text" value="<?php echo isset($grade_set[5])?$grade_set[5]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>
				<td class="b_"><input class="form-control" name="to_ba" id="4"  onkeyup="changeto('b',this.value);"  type="text" value="<?php echo isset($grade_set[4])?$grade_set[4]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>	
			</tr>
			<tr>	
				<th>BC</th>
				<td class="_d"><input class="form-control" name="from_bb"  onkeyup="changefrom('d',this.value);"	type="text" value="<?php echo isset($grade_set[7])?$grade_set[7]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>									
				<td class="c_"><input class="form-control" name="to_bb" id="5"  onkeyup="changeto('c',this.value);"  type="text" value="<?php echo isset($grade_set[6])?$grade_set[6]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>	
			</tr>
			<tr>	
				<th>CC</th>
				<td class="_e"><input class="form-control" name="from_cc"  onkeyup="changefrom('e',this.value);"	type="text" value="<?php echo isset($grade_set[9])?$grade_set[9]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>
				<td class="d_"><input class="form-control" name="to_cc" id="6"  onkeyup="changeto('d',this.value);"  type="text" value="<?php echo isset($grade_set[8])?$grade_set[8]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>	
			</tr>
			<tr>	
				<th>CD</th>
				<td class="_f"><input class="form-control" name="from_cd"  onkeyup="changefrom('f',this.value);"  type="text" value="<?php echo isset($grade_set[11])?$grade_set[11]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>																			
				<td class="e_"><input class="form-control" name="to_cd" id="7"  onkeyup="changeto('e',this.value);"  type="text" value="<?php echo isset($grade_set[10])?$grade_set[10]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>	
			</tr>
			<tr>	
				<th>DD</th>
				<td class="_g"><input class="form-control" name="from_dd"  type="text" value="<?php echo isset($grade_set[13])?$grade_set[13]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>																			
				<td class="f_"><input class="form-control" name="to_dd" id="7"  onkeyup="changeto('f',this.value);"  type="text" value="<?php echo isset($grade_set[12])?$grade_set[12]:'' ; ?>" min=0 max=100 required pattern="[0-9]{1,3}" /></td>	
			</tr>			
		
	</div> <!-- /.box body -->
	<div class="box-footer">
		<button type="submit" class="btn btn-primary" name='submit'>Save</button>
		<?php if(isset($grade_set[1]))
		{
		
		?>
		<button type="button" onclick="load_table('<?php echo "grade_table.php?id=".Input::get('id'); ?>');" class="btn btn-danger" >Cancel</button>
		
		<?php 
		}
		?>
		</form>
		</table>
	</div>



</div>
<script src="js/grade_set.js"></script>
<script>
	function changefrom(i_id, value){
		$("."+i_id+"_ input").val((--value));
	}
	function changeto(i_id, value){
		$("._"+i_id+" input").val((++value));
	}
</script>

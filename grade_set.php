<?php
require_once 'core/init.php';
if(!loggedIn() || privilege()==NULL){
	die();
}
	$cid_dep = explode(',',Input::get('id'));
	$cid=$cid_dep[0];
	$dep=$cid_dep[1];
	$gmarks = new Marks();				
	$scale = $gmarks->getGradeScale($cid,$dep);
	$grade_set = explode(',',$scale);
?>

	<div class="box box-default" id="formula">
	
			<div class="box-header">
				<h3 class="box-title">Sessional Formula</h3>
			</div> <!-- /.box header -->
			<!-- form start -->
			<form role="form" action="post" id="sessional_formula">
				<div class="box-body">
					<div class="form-group">
						<label for="formula">Select formula</label>
						    <?php 
						       $sf = $gmarks->getSessionalFormula(Session::get('teacher_id'),$cid,$dep);
	                           if($sf->num_rows){
	                               $formula = $sf->fetch_object()->formula;
	                           }else{
	                               $formula=1;
	                           }
						    ?>
							<select name="formula" class="form-control" id="formula">
								<option value="" <?php echo ($formula==0?'selected':''); ?>>Formula</option>
								<option value="1" <?php echo ($formula==1?'selected':''); ?>>Highest of Two Class Tests + Internal Assessment (Default)</option>
								<option value="2" <?php echo ($formula==2?'selected':''); ?>>Average of Two Class Tests + Internal Assessment</option>
							</select>
						</div>
					</div> <!-- /.box body -->
					<div class="box-footer">
						<input type="hidden" name="ccode" value="<?php echo $cid; ?>">
						<input type="hidden" name="cdep" value="<?php echo $dep; ?>">
						<button type="submit" class="btn btn-primary" name='submit'>Save</button>
					</div><!-- /.box footer -->
			</form>
			</div>
	</div>
	<div id="grade_table" class="box box-default">
	<?php 
		if(isset($grade_set[1]))
		{
			require_once('grade_table.php');
		}
		else {
			require_once ('set_grade_table.php');
		}
	
	?>
	</div>
<script src="js/sessional_formula.js"></script>
<script>
	function load_table(hrf){
		$('#grade_table').load(hrf);
	}
</script>
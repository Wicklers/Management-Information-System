
<?php 
require_once 'core/init.php';
if(!loggedIn()){
	die();
}
if(!Input::exists('get')){
	die();
}
else{
	$t = new Student();
	$tt = $t->getInfo(Input::get('sid'));
?>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/edit_student.js"></script>
<form id="edit_student" method="post">
	<legend>Edit Details</legend>
			<table class="table table-bordered table-striped">
					<tbody>                                     
							<tr>
                                <th>Scholar Number</th>
                                <td><input type='hidden' name='scholar_no' value='<?php echo Input::get('sid'); ?>'><?php echo Input::get('sid'); ?></td>
							</tr>
							<tr>
                                <th>Name</th>
                                <td><?php echo $t->getName(); ?></td>
                            </tr>
							<tr>
                                <th>Department</th>
						<td>
						<select name="department">
							<option value="" selected>Department</option>
							<?php
								$dep = new Department();
								$departments = $dep->getAllDepartment();
								while($department = $departments->fetch_object()){
							?>
							<option value="<?php echo $department->dept_id; ?>" <?php echo (($t->getDep()==$department->dept_id)?'selected':''); ?>><?php echo $department->name; ?></option>
							<?php
								}
							?>
						</select>
					</td>
							</tr>
							<tr>
                                <th>Sem</th>
                                <td><?php echo $t->getSemester(); ?></td>
                            </tr>
							<tr>
                                <th>Mobile</th>
                                <td>
                                	<input type="text" maxlength="10" name="mobile" class="form-control" placeholder="student\'s mobile number" value="<?php echo $t->getMobile(); ?>" />
                                </td>
							</tr>
							<tr>
                                <th>Parent's<br/>Mobile</th>
                                <td><input type="text" maxlength="10" name="parents_mobile" class="form-control" placeholder="parent\'s mobile number" value="<?php echo $t->getParentsMobile(); ?>" /></td>
                            </tr>
							<tr>
                                <th>Regular <br/> Courses</th>
				<td>
				<textarea name="courses" class="form-control" placeholder="Regular Courses"><?php echo $t->getCourses(); ?></textarea>
				</td>
							</tr>
							<tr>
                                <th>Load <br/> Courses</th>
                                <td>
				<textarea name="courses_load" class="form-control" placeholder="Load Courses"><?php echo $t->getCoursesLoad(); ?></textarea>
				</td>
							</tr>
							<tr>
                                <th>Total Credit Scored</th>
                                <td><input type="text" maxlength="10" name="total_score" class="form-control" placeholder="total score" value="<?php echo $t->getTotalScore(); ?>" /></td>
                            </tr>
							<tr>
                                <th>Total Credit Point</th>
                                <td><input type="text" maxlength="10" name="max_score" class="form-control" placeholder="max score" value="<?php echo $t->getMaxScore(); ?>" /></td>
                            </tr>
							<tr>   
                                <th>Home<br/>Address</th>
                                <td>
									<textarea name="home_address" class="form-control" placeholder="Home Address"><?php echo $t->getHomeAddress(); ?></textarea>
								</td>
							</tr>
							<tr>	
                                <th>Hostel<br/>Address</th>
                                <td>
									<textarea name="hostel_address" class="form-control" placeholder="Hostel Address"><?php echo $t->getHostelAddress(); ?></textarea>
								</td>
							</tr>
							<tr>	
                                <th>Payment</th>
                                <td><?php echo (($t->getPayment())?'Completed':'Not Completed'); ?></td>
							</tr>
							<tr>
                                <th>Approved</th>
                                <td>
									<select name="approved" class="form-control">
										<option value="0" <?php echo (($t->getApproved()=='0')?'selected':''); ?>>Not Approved</option>
										<option value="1" <?php echo (($t->getApproved()=='1')?'selected':''); ?>>Approved</option>
									</select>
								</td>
							</tr>
							<tr>	
                                <th>Blocked</th>
                                <td>
									<select name="blocked" class="form-control">
										<option value="0" <?php echo (($t->getBlocked()=='0')?'selected':''); ?>>Not Blocked</option>
										<option value="1" <?php echo (($t->getBlocked()=='1')?'selected':''); ?>>Blocked</option>
									</select>
								</td>
                            </tr>
							<tr>
								<td>
									<input type="submit" value=" &nbsp;Save&nbsp; " class="btn btn-success" name = "submit" />
								</td>
								<td>
									<input type="button" class="btn btn-danger" value="Cancel" onClick="save_edit_s()"; />
								</td>
								
							</tr>
						</tbody>
				</table>
</form>
<?php
}
?>


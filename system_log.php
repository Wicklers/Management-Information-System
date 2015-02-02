<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
else if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc') || privilege()==='student'){
    include('includes/errors/404.php');
    die();
}
?>
<link rel="icon" href="images/nits2.jpg">
<link rel="shortcut icon" href="images/nits2.jpg" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/result.css">
<script>
	function load_pie(type){
		$("#pie").load('ajax/log_pie.php?type='+type);
	}
</script>
<div class="tableh">System Log</div>
		<div class="res">
			<table>
				<tr>
					<td class="sel">
						Select Log Type
					</td>
					<td>
						<select name="credit" class="box" OnChange="load_pie(this.value);">
							<option value="" selected>Default</option>
							<option value="actions">All Actions Performed</option>
							<option value="logins">Login Attempts</option>
							<option value="new">New Entries</option>
							<option value="edits">Entries Edited</option>
							<option value="deleted">Entries Deleted</option>
						</select>
					</td>
				</tr>
						
				<tr>
					<td colspan="2">
					</td>
				</tr>
			</table>
		</div>
		<div id="pie">
		<img src="log_pie.php?type=" height="300px" width="600px"/>
		</div>
		
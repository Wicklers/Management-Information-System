$(document).ready(function(){
	$('#nav1').click(function(){
		$('#loading').show();
		$('#load_win').load('set_last_date.php');
		$('.sub_menu').css('background','#000000');
		$('#nav1').css('background','#4c4c4c');
		document.title = "Last Dates | MIS";
		window.history.pushState({"page":"set_last_date.php"}, null, 'last_date.php');
	});
	$('#nav2').click(function(){
		$('#loading').show();
		$('#load_win').load('enter_marks.php');
		$('.sub_menu').css('background','#000000');
		$('#nav2').css('background','#4c4c4c');
		document.title = "Marks Entry | MIS";
		window.history.pushState({"page":"enter_marks.php"}, null, 'marks.php');
	});
	$('#nav3').click(function(){
		$('#loading').show();
		$('#load_win').load('go_approval.php');
		$('.sub_menu').css('background','#000000');
		$('#nav3').css('background','#4c4c4c');
		document.title = "Result & Approval | MIS";
		window.history.pushState({"page":"go_approval.php"}, null, 'approval.php');
	});
	$('#nav4').click(function(){
		$('#loading').show();
		$('#load_win').load('set_last_date.php');
		$('.sub_menu').css('background','#000000');
		$('#nav4').css('background','#4c4c4c');
		document.title = "Last Dates | MIS";
		window.history.pushState({"page":"set_last_date.php"}, null, 'set_last_date.php');
	});
	
	window.onpopstate = function(event){
		if(event.state==null){
				window.location.reload();
		}
		else{
			$('#loading').show();
			window.location.reload();
		}
	};
	
});

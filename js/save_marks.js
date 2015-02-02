$(document).ready(function() {
	var options = { 
			target:        '#update',   // target element(s) to be updated with server response 
			beforeSubmit:  showRequest,  // pre-submit callback 
	        success:       showResponsemsg,  // post-submit callback 
			url:'ajax/save_marks.php',
			type: 'post',
			};
			
			$('#savemarks').ajaxForm(options);
	
			var options1 = { 
					target:        '#update',   // target element(s) to be updated with server response 
					beforeSubmit:  showReq,  // pre-submit callback 
			        success:       showRes,  // post-submit callback 
					url:'ajax/save_marks_load.php',
					type: 'post',
					};
					
					$('#savemarks_load').ajaxForm(options1);
		
});

function showRequest(formData, jqForm, options) { 
    
    var queryString = $.param(formData); 
    return true; 
} 

// post-submit callback 
function showResponsemsg(responseText, statusText, xhr, $form)  { 
    
		$('#updateModal').modal();
  
   return true;
   
}

function showReq(formData, jqForm, options) { 
    
    var queryString = $.param(formData); 
   
    return true; 
} 

// post-submit callback 
function showRes(responseText, statusText, xhr, $form)  { 
    
		$('#updateModal').modal();
    
   return true;
   
}
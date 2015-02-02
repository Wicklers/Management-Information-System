$(document).ready(function() {
	var options = { 
		target:        '#form_data',   // target element(s) to be updated with server response 
		beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponsemsg,  // post-submit callback 
		url:'ajax/load_form.php',
		type: 'post',
		};
		
		$('#marks_enter').ajaxForm(options);
		
});

function showRequest(formData, jqForm, options) { 
    
    var queryString = $.param(formData);
    return true; 
} 

// post-submit callback 
function showResponsemsg(responseText, statusText, xhr, $form)  { 
   return true;
   
}
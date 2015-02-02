$(document).ready(function() {
	var options = { 
		target:        '#preview',   // target element(s) to be updated with server response 
		beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponsemsg,  // post-submit callback 
		url:'ajax/update_biography.php',
		type: 'post',
		};
		
		$('#update_biography').ajaxForm(options);
		


function showRequest(formData, jqForm, options) { 
     
    var queryString = $.param(formData);
    
    return true; 
} 

// post-submit callback 
function showResponsemsg(responseText, statusText, xhr, $form)  { 
	
   return true;
   
}
});
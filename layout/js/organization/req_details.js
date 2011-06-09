function req_details_main(){
	
	$('#submittedon').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
	
	$('#submitted').change(on_change_submitted_status);
	$('#submitted').change();
}

function on_change_submitted_status(){
	if(requirement_is_submitted())
		$('.submitteddetails').fadeIn('slow');
	else
		$('.submitteddetails').fadeOut('slow');
}

function requirement_is_submitted(){
	return($('#submitted').val() == 1);
}

$(document).ready(req_details_main);

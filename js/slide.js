$(document).ready(function() {
	
	$('.move-options').hide();

	$('#slideTrigger').click(function() {
		$('.move-options').slideDown('medium', function(){
			$('#slideTrigger').fadeOut('medium', function() {
				$(this).html('Move To').fadeIn('fast');
			});					
		});				
	});
	
	
	
	
});
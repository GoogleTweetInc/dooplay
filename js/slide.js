$(document).ready(function() {
	
	$('.move-options').hide();

	$('#slideTrigger').click(function() {
		$('.move-options').slideDown('medium', function(){
			$('#slideTrigger').fadeOut('medium', function() {
				$(this).html('Move To').fadeIn('fast');
			});					
		});				
	});
	
	
	$('.changename a').click(function() {
				$(this).fadeOut('medium', function() {
					//var track = '';
					$('.changename').append(
						"<form action='includes/change_title.php' method='post'>" +
							"<input type='text' name='new_name' value='<?php echo $trackname; ?>'>" +
							"<input type='hidden' name='playlist_id' value='<?php echo $playlist; ?>'>" +
							"<input type='hidden' name='track_id' value='<?php echo $track_id; ?>'>" +
							"<input type='submit' name='change' value='Change'>" +							 
						"</form>"
					).hide().fadeIn('fast');
					
				});
			});
			
			$('.changename').mouseenter(function() {
				$("input[value='Change']").css({"background": "darkcyan", "color": "black"});
			});
			
			$('.changename').mouseleave(function() {
				$("input[value='Change']").css({"background": "black", "color": "white"});
			});
			
			
			$('#movetr').hide();
			
			$('.move-options select').on('change', function() {
				$('#movetr').fadeIn('slow');
			});
	
			$('#audio-image img').click(function() {
				$(this).fadeOut('medium', function() {
					$('#audio-image').append(
						"<form action='' method='post' enctype='multipart/form-data'>" +
							"<input type='file' name='new_cover' id='newCover'>" +
							"<br>" +
							"<input type='submit' name='apply_new_cover' id='submitCover' value='change'>" +
						"</form>"
					).hide().fadeIn('slow');
					//$('#submitCover').hide();
				});
			});

						//$('#add-track').hide();
						
						var addTrackForm = "<form action='' method='post' enctype='multipart/form-data'>" +
												"<input type='file' name='track'>" +
												"<br>" +
												"<input type='submit' name='addtrack' value='Add' id='submitTrack'>" +
											"</form>";
						
						$('#showfilebtn').click(function(){
							$(this).fadeOut('fast', function() {
								$('#add-track').append(addTrackForm).hide().fadeIn('fast');
							});
							
							
						});
						
	
});

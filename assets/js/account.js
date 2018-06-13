"use strict";
$(document).ready(function() {
	var fd = null;
	$('div#account-info *').css('margin', '5px');
	$('img#profile-pic').css('display', 'block');
	$('p#profile').click(function() {
		$('div#add-image').toggle();
	});
	$('span.btn.btn-info.btn-sm').click(function(){
		$('#result').hide();
	});
	$("[type=file]").change(function(){
		
		var files = $('[type=file]')[0].files[0];
		console.log(typeof files);
		if (typeof files != 'undefined' ) {
			fd = new FormData();
        	fd.append('file',files);
		} else {
			fd = null;
		}
	});
	$('input.submit').click(function(){
		if( fd != null ) {
			$.ajax({
				type: "POST",
				data: fd,
				contentType: false,
				processData: false,
				url: location + '/doUpload',
				success: function(resp) {
					var answ = $.parseJSON(resp)['error'];
					if ( answ != null ) {
						result( answ, fd );
					} else {
						$('#add-image').hide();;
						result( 'The file was uploaded.' );
						
					}
				},
			});
		} else {
			result('Please select a file to upload.' );
		}
	});
});

function result( rs ) {
	$("#fileopen").val("");
	$('#result').empty();
	$('#result').append('<p>' + rs  + '</p>');
	$('#result').show();
}
"use strict";
$(document).ready(function() {
	$.ajax({
		url: location + '/get_timezone',
		success: function(resp) {
			new Clock(1000, resp);
		},
	});
});

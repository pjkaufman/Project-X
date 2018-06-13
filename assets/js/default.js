"use strict";
$(document).ready(function() {
	var title = document.getElementsByTagName("title")[0].innerHTML;
	title = title.replace('Project X - ', '');
	if (title != 'Register' && title != 'Login') {
		$.ajax({
			url: location + '/getTimezone',
			success: function(resp) {
				new Clock(1000, resp);
			},
		});
	}
});

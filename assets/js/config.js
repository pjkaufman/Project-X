"use strict";
$(document).ready(function() {
	var timezone;
	$.ajax({
		type: "POST",
		url: location + '/get_timezone',
		success: function(resp) {
			timezone = resp;
		},
	}).then(function() {
		$.ajax({
			type: "POST",
			url: location + '/time_zones',
			dataType: 'json',
			success: function(resp) {
				var markup;
				markup = '<option id="default" value="' + timezone + '">' + timezone + '</option>';
				for (var row in resp) {
					if (resp[row] != timezone) {
						markup += '<option id="' + row + '" value="' + resp[row] + '">' + resp[row] + '</option>';
					}
				};
				$('select.time_zone').append(markup).select2();
			},
		});
		$('div.col-sm-3 button#time_zone.update').on('click', function() {
			timezone = document.getElementsByClassName("select2-selection__rendered")[0].getAttribute('title');
			var time_zone = {
				'time_zone': timezone
			};
			$.ajax({
				type: "POST",
				data: time_zone,
				url: location + '/update_timezone',
				success: function() {
					clearInterval(clockInterval);
					$('div#clock').empty();
					new Clock(1000, timezone);
				},
			});
		});
	});
});

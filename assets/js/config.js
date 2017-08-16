"use strict";
$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: location + '/time_zones',
		dataType: 'json',
		success: function(resp) {
			var markup;
			for (var row in resp) {
				markup = '<option id="' + row + '" value="' + resp[row] + '">' + resp[row] + '</option>';

				$('select.time_zone').append(markup).select2();

			};
		},
	});
	$('div.col-sm-3 button#time_zone.update').on('click', function() {
		var time_zone = {
			'time_zone': document.getElementsByClassName("select2-selection__rendered")[0].getAttribute('title')
		};
		$.ajax({
			type: "POST",
			data: time_zone,
			url: location + '/update_timezone',
		});
	});
});

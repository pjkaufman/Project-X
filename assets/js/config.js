"use strict";
$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: location + '/get_config_data',
		dataType: 'json',
		success: function(resp) {
			var markup;
			for (var row in resp) {

				markup = '<div id="' + resp[row]['name'] + '" class="row" style="margin:10px;"><label class="col-sm-4">' + firstLetterToUpper(resp[row]['name']) + ' Version: </label>' +
					'<input class="col-sm-6" id="' + resp[row]['name'] + '" type="text"  placeholder="' + resp[row]['version'] + '">' +
					'<div class="col-sm-1"></div><button class="col-sm-1 update" id="' + resp[row]['name'] + '" style="width:auto;">Update</button></div>';

				$('div#versions').append(markup);
			};
			$('button.update').click(function() {
				updateItem(this.id, $('input#' + this.id).val());
			});
		},
	});
});

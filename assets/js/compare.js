"use strict";
$(document).ready(function() {
	$('pre').hide();
	$('.spinner').hide();
	$('div.reset').click(function() {
		$('h4#rTitle').text('');
		$('pre').hide();
		$('pre').empty();
	});
	$('div.Snapshot').click(function() {
		$('.spinner').show();
		$.ajax({
			type: "POST",
			url: location + '/takeSnapshot',
			success: function() {
				$('.spinner').hide();
				$('h4#rTitle').text("Database Snapshot was taken.");
			},
		});
	});
	$('div.DB2').click(function() {
		$('.spinner').show();
		var data = {
			num: 'false'
		};
		$.ajax({
			type: "POST",
			data: data,
			url: location + '/dbCompare',
			success: function(resp) {
				$('.spinner').hide();
				var todo = $.parseJSON(resp);
				$('h4#rTitle').text(todo.title);
				$('pre').empty();
				$.each(todo.sql, function(propName, propVal) {
					$('pre').append('<p>' + propVal + '</p>');
					$('pre').show();
				})
			},
		});
	});
	$('div.DB1').click(function() {
		$('.spinner').show();
		var data = {
			num: 'true'
		};
		$.ajax({
			type: "POST",
			data: data,
			url: location + '/dbCompare',
			success: function(resp) {
				$('.spinner').hide();
				var todo = $.parseJSON(resp);
				$('h4#rTitle').text(todo.title);
				$('pre').empty();
				$.each(todo.sql, function(propName, propVal) {
					$('pre').append('<p>' + propVal + '</p>');
					$('pre').show();
				})
			},
		});
	});
});

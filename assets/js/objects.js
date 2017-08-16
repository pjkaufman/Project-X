"use strict";
/**
 * @author Peter Kaufman
 * @class Clock
 * @type class
 * @author Peter Kaufman
 * @param i is the interval at which the clock updates in milliseconds
 * @description Wrapper for {@link https://codepen.io/gab/pen/KLhgr}.
 *  Clock objects allow easy construction of a clock, credit to Gabriel
 * @returns void
 */
var Clock = function(i) {
	/**
	 * @function update
	 * @description Initializes the Clock object
	 * @memberOf Clock
	 * @returns void
	 */
	function update() {
		$('#clock').html(moment().format('D MMMM, YYYY, H:mm:ss'));
	}

	setInterval(update, i);

};
/**
 * @author Rance Aaron & Peter Kaufman
 * @class Table
 * @type object
 * @description Wrapper for {@link https://datatables.net DataTables}.
 *  Table objects allow easy construction for data tables with connections
 *  to the data sources.
 *
 */
var Table = {
	/**
	 * @function init
	 * @description Initializes the table object
	 * @memberOf Table
	 * @param {string} name Name used as dom element id
	 * @param {string} url Url to data source
	 * @param {array} columns Column names
	 * @param {boolean} server server determines if serverSide is to be used
	 * @returns void
	 */
	init: function(name, url, columns, server) {
		this.col_array = columns;
		this.name = name;
		this.url = url;
		this.createTable();

		$('table#' + this.name).DataTable({
			serverSide: server,
			dom: '<"top"lip>t<"bottom"><"clear">',
			ajax: url,
			columns: this.getColumns(),
			fnDrawCallback: function(oSettings) {
				$('div.dataTables_length label').attr('style', 'padding-top: 11px; margin-right: 20px;')
				$('div.dataTables_info').attr('style', 'clear:none;')
			}
		});

		var dTable = $('table#' + this.name).DataTable();
		for (var i in this.col_array) {
			$(dTable.column(i).header()).text(this.col_array[i]);
		}
	},
	/**
	 * @function createTable
	 * @description Creates a dom element for the table object
	 * @memberOf Table
	 * @returns void
	 */
	createTable: function() {
		$("div#table ").append('<table id="' + this.name + '" class="display" cellspacing="0" width="100%" />');
	},
	/**
	 * @function getColumns
	 * @description Return an array of column data
	 * @memberOf Table
	 * @returns {Array|Table.getColumns.c}
	 */
	getColumns: function() {
		var c = [];

		for (var k in this.col_array) {
			c.push({
				"data": this.col_array[k]
			});
		}

		return c;
	}
};
/**
 * @class DatePicker
 * @example First include the following element into the markup HTML for a concrete element.  <div class="drp"></div>
 * @example Call the constructor in a javascript file.  var mydatepicker = new DatePicker(start, end, 0);
 * @param {string} start Start date
 * @param {string} end End date
 * @param {int} time Use 1 to enable time picker option
 * @returns {DatePicker}
 */
function DatePicker(start, end, time) {
	var tp;
	if (time === 0) {
		tp = false;
		var format = 'MM/DD/YYYY';
	} else {
		tp = true;
		var t = {
			format: 'MM/DD/YYYY HH:mm:ss'
		};
	}
	this.start = moment(start).format("MM/DD/YYYY");
	this.end = moment(end).format("MM/DD/YYYY");
	this.markup = '<div style="position: relative; width: auto; height: 36px; margin-bottom: 10px;" class="rangecontainer">\n\
                        <div style="position: absolute;top: 0px;bottom: 0px;display: block;left: 0px;right: 50%;padding-right: 20px;width: 50%;"><input style="height: 100%;display: block;" type="text" name="start" id="start" class="form-control" /></div>\n\
                        <div style="position: absolute;top: 0px;bottom: 1px;display: block;left: 50%;z-index:+2;margin-left: -20px;width: 40px;text-align: center;background: linear-gradient(#eee,#ddd);border: solid #CCC 1px;border-left: 0px;border-right: 0px;height: 36px !important;"><i style="position:absolute;left:50%;margin-left:-7px;top:50%;margin-top: -7px;" class="fa fa-calendar"></i></div>\n\
                        <div style="position: absolute;top: 0px;bottom: 0px;display: block;left: 50%;right: 0px;padding-left: 20px;width: 50%;"><input style="height: 100%;display: block;" type="text" name="end" id="end" class="form-control" /></div>\n\
                   </div>';

	$("div#drp").html(this.markup);

	function update(t) {
		if (t === 1) {
			var format = 'YYYY-MM-DD HH:mm:ss';
		} else {
			var format = 'YYYY-MM-DD';
		}

		window.DatePicker.daterange = {
			start: moment($('.rangecontainer input#start').val()).format(format),
			end: moment($('.rangecontainer input#end').val()).format(format),
			diff: moment($('.rangecontainer input#end').val()).diff(moment($('.rangecontainer input#start').val()), 'days')
		};
	};

	new Drp(this.start, time, 'start');
	new Drp(this.end, time, 'end');

	update(time);

	$('div#drp .rangecontainer').on('change', 'input', function(e) {
		update(time);
	});

	/**
	 * @author Rance Aaron
	 * @class Drp
	 * @description Wrapper object for date range picker
	 * @type object
	 * @param {string} d date passed by constructor
	 * @param {int} type Type of output format and either datepicker or datetimepicker
	 * @param {string} se Start or End
	 */
	function Drp(d, type, se) {
		if (type == 1) {
			this.time = true;
			var t = {
				format: 'MM-DD-YYYY HH:mm:ss'
			};
		} else {
			this.time = false;
			var t = {
				format: 'MM-DD-YYYY'
			};
		}


		$('div#drp .rangecontainer input#' + se).daterangepicker({
				parentEl: "#drp",
				singleDatePicker: true,
				showDropdowns: false,
				locale: t,
				startDate: d,
				timePicker: this.time,
				autoApply: true,
				autoUpdateInput: true,
				maxDate: moment().format(t.format)
			},
			function(start, end, label) {
				return start;
			}
		);
	}
}

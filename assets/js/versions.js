"use strict";
$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: location + '/get_version_data',
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
	$('ul.nav.navbar-nav.navbar-right button').click(function() {
		var markup;
		if (this.id == 'remove') {
			markup = '<div class="modal fade remove" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">' +
				'<div class="modal-dialog"><div class="modal-content"><div class="modal-header" style="background-color:black;">' +
				'<h3 class="modal-title" id="lineModalLabel" style="color:#fff;">Remove Dependency or Plugin</h3></div>' +
				'<div class="modal-body"><div class="form-group"><label for="name">Name</label><input type="text" class="form-control" id="name" placeholder="Enter Name of Dependency or Plugin">' +
				'</div></div><div class="modal-footer"><div class="btn-group btn-group" role="group" aria-label="group button">' +
				'<div class="btn-group" role="group">' +
				'<button type="button" id="close" class="btn btn-default btn-hover-green" data-dismiss="modal">Close</button>' +
				'<button type="button" id="Remove" class="btn btn-default btn-hover-green" role="button" style="color:#fff;background-color:#d9534f;border-color:#d9534f;">Remove</button>' +
				'</div></div></div></div></div></div>';
		} else {
			markup = '<div class="modal fade add" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">' +
				'<div class="modal-dialog"><div class="modal-content"><div class="modal-header" style="background-color:black;">' +
				'<h3 class="modal-title" id="lineModalLabel" style="color:#fff;">Add Dependency or Plugin</h3></div>' +
				'<div class="modal-body"><div class="form-group"><label for="name">Name</label><input type="text" class="form-control" id="name" placeholder="Enter Name of Dependency or Plugin">' +
				'</div><div class="form-group"><label for="version">Version</label><input type="text" class="form-control" id="version" placeholder="0.0.1">' +
				'</div></div><div class="modal-footer"><div class="btn-group btn-group" role="group" aria-label="group button">' +
				'<div class="btn-group" role="group">' +
				'<button type="button" id="close" class="btn btn-default btn-hover-green" data-dismiss="modal">Close</button>' +
				'<button type="button" id="Add" class="btn btn-default btn-hover-green" role="button" style="color:#fff;background-color:#286090;border-color:#204d74;">Add</button>' +
				'</div></div></div></div></div></div>';
		}
		modalShow(markup, this.id);
	});

});

/**
 * @author Peter Kaufman
 * @description firstLetterToUpper makes the first letter of the string upercase
 * @example firstLetterToUpper('car') results in Car
 * @function firstLetterToUpper
 * @access public
 * @param {string} str, the string to have its first letter capitalized
 * @return {string} the input string with an upercase first letter
 */
function firstLetterToUpper(str) {
	return str.substring(0, 1).toUpperCase() + str.substring(1);
}

/**
 * @author Peter Kaufman
 * @description modalShow shows a modal based on which button has been clicked
 *              it also adds the button listeners to add and remove the input data
 * @example modalShow(
 *          '<div class="modal fade blob" id="squarespaceModal" tabindex="-1"
 *          role="dialog" aria-labelledby="modalLabel" aria-hidden="true">...Modal Content...</div>', 'blob' );
 *          shows the modal with the desired content on the screen
 * @function modalShow
 * @access public
 * @param {string} markup is the markup of the modal. Markup must include a div with the id modal-container,
 *                   a div with the id of the id param, a button with an id of close, and another button with
 *                   an id of either Add or Remove.
 * @param {string} id is the id of the modal to show
 * @return {null} void
 */
function modalShow(markup, id) {

	var data;

	$('div#modal-container').append(markup);
	$('div#modal-container div.' + id).modal('show');

	$('button#close').click(function() {
		removeModal();
	});

	if (id == 'remove') {
		$('div.modal-footer button#' + firstLetterToUpper(id)).click(function() {
			data = {
				'id': id,
				'name': $('input#name.form-control').val().toLowerCase(),
			};
			updateTable(data);
			$('div#' + data.name + '.row').remove();
		});
	} else {
		$('div.btn-group button#' + firstLetterToUpper(id)).click(function() {
			data = {
				'id': id,
				'name': $('input#name.form-control').val().toLowerCase(),
				'version': $('input#version.form-control').val(),
			};
			updateTable(data);
			var markup = '<div id="' + data.name + '" class="row" style="margin:10px;"><label class="col-sm-4">' + firstLetterToUpper(data.name) + ' Version: </label>' +
				'<input class="col-sm-6" id="' + data.name + '" type="text"  placeholder="' + data.version + '">' +
				'<div class="col-sm-1"></div><button class="col-sm-1 update" id="' + data.name + '" style="width:auto;">Update</button></div>';
			$('div#versions').append(markup);
		});
	}
}

/**
 * @author Peter Kaufman
 * @description updateItem updates the plugin's or dependency's version
 * @example updateItem('php','7.0.0'); updates the version of php to be 7.0.0
 * @function updateItem
 * @access public
 * @param {string} name is the name of the version to update
 * @param {string} version is the new version of the plugin or dependency
 * @return {null} void
 */
function updateItem(name, version) {
	var data = {
		'name': name,
		'version': version,
	};
	$.post(location + '/update_version', data);
}

/**
 * @author Peter Kaufman
 * @description removeModal removes any modal on the screen
 * @example removeModal(); removes all modals from the screen
 * @function removeModal
 * @access public
 * @return {null} void
 */
function removeModal() {
	$('div#modal-container').empty();
	$('div.modal-backdrop').remove();
}

/**
 * @author Peter Kaufman
 * @description updateTable determines whether to remove or add a record to the versions table
 * @example updateTable( var data = ['id':'add'.'name':'blob', 'version':'2.0']); adds blob to the versions
 *          table with 2.0 as its version
 * @function updateTable
 * @access public
 * @param {array} data contains an id, name, and version
 * @return {null} void
 */
function updateTable(data) {
	$.post(location + '/update_version_table', data);
	removeModal();
}

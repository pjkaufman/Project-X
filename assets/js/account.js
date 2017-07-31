$(document).ready(function() {
	$('div#account-info *').css('margin', '5px');
	$('img#profile-pic').css('display', 'block');
	$('p#profile').click(function() {
		$('div#add-image').toggle();
	});
});

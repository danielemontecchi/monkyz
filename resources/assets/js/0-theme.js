$(document).ready(function(){

	// enlarge image
	$('.img-thumbnail').hover(function() {
		$(this).addClass('transition');
	}, function() {
		$(this).removeClass('transition');
	});


	// delete button
	$('table .btn-delete-record').on('click', function() {
		return confirm('Do you want to delete this record?');
	});


	// logout
	function logout() {
		return confirm('Do you want to logout?');
	}
	$('#logout a').on('click', function() {
		return logout();
	});

	// settings reset default
	$('#settingsResetDefault').on('click', function() {
		return confirm('Do you want reset the default settings?');
	});
	

});
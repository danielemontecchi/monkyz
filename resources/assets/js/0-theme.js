
// enlarge image
$(document).ready(function(){
	$('.img-thumbnail').hover(function() {
		$(this).addClass('transition');
	}, function() {
		$(this).removeClass('transition');
	});
});


// delete button
$(function() {
	$('table .btn-delete-record').on('click', function() {
		return confirm('Do you want to delete this record?');
	});
});
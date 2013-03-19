$(document).ready(function () {
	$('#edit-profile-btn').click(function () {
		app.router.navigate('edit', {trigger:true});		
	});
	
	$('#edit-contacts-btn').click(function () {
		app.router.navigate('contacts', {trigger:true});
	});

	$('#myContacts').on('hidden', function() {
		app.router.navigate('/');
	});
});
$(function() {	
	window.app = [];
	ProfileRouter = Backbone.Router.extend({
	    routes: {
	        'edit': 'edit',
	        'contacts': 'contacts'
	    },
	    edit: function () {
	    	$('#tab-about').tab('show');
			$('#edit-btn').trigger('click');
	    },
		contacts: function () {
	    	$('#myContacts').modal('show');
			$('#edit-contacts-btn').trigger('click');
	    }	    
	});	

	app.router = new ProfileRouter();
});	
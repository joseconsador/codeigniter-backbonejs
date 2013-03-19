var AddEmployeeView = Backbone.View.extend({
	el: '#addModal',	
	show: function() {		
		this.$el.modal('show');
		$('#n_new_user').trigger('click');
	},
	initialize: function() {
		this.model = new Employee();
	},
	events: {	
		'click .modal-footer .btn-primary' : 'save',
		'change input' : 'change'
	},
    change: function(e) {
        this.model.set($(e.target).attr('id'), $(e.target).val());
    },	
	save: function(e) {
		$(e.target).text('Saving...').attr('disabled', true);
				
		// remove error messages if any.
		this.$el.find('.label-important').remove();

		// Save user then proceed to 201
		this.model.save('', '', {
			success: function(model, response) {
				window.location = BASE_URL + 'hr/employee/' + model.get('hash') + '#/edit';
			},
			error: function(model, xhr) {
                response = $.parseJSON(xhr.responseText);

                $.each(response.message, function(field, error) {                	
                	errors = _.values(error).join(', ');

                	$('#' + field).after('<span class="label label-important">' + errors + '</span>');
                });

                $(e.target).text('Save and continue').removeAttr('disabled');
			}
		});
	}
});
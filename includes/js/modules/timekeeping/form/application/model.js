// --------------------------------------------------------------------
// 
var Form = Backbone.Model.extend({		
	idAttribute: 'form_application_id',	
	statusUpdater: null,
	initialize: function() {
		this.statusUpdater = new FormUpdateStatusModel(this.toJSON());
	},
	defaults: function() {
		return {
            form_application_id: null,
            form_type_id: 0,
    		employee_id: 0,
    		date_from: new Date(),
    		date_to: new Date(),
    		reason: '',		
    		can_approve: false,
            locked: false
        };
	},
    url: function () {
    	if (this.isNew()) {
        	return BASE_URL + 'api/form';
    	} else {
    		return BASE_URL + 'api/form/id/' + this.id;
    	}
    },
    changeStatus: function(status) {
    	var that = this;

    	this.statusUpdater.action = status;
    	this.statusUpdater.save('', '', {
    		success: function() {
    			that.trigger('sync');
    		}
    	});    	
    }
});

var FormUpdateStatusModel = Backbone.Model.extend({
	idAttribute: 'form_application_id',	
	action: null,
    url: function () {
    	return BASE_URL + 'api/form/id/' + this.id + '/' + this.action;
    }
})

var FormCollection = Backbone.Collection.extend({model: Form});
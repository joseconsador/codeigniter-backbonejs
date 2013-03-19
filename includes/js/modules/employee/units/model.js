// --------------------------------------------------------------------
// 
var UnitModel = Backbone.Model.extend({
    defaults: {
        employee_id: 0,
        equipment: '',
        tag_number: '',
        status: '',
        date_issued: '',
        date_returned: '',
        cost: '',
        quantity: '',
        remarks: '',
        attachment: [0],
        filename: '',
        log_uploads_id: 0
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/unit';
    	} else {
    		return BASE_URL + 'api/unit/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var UnitCollection = Backbone.Collection.extend({
    model: UnitModel,
});
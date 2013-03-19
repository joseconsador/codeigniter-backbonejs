// --------------------------------------------------------------------
// 
var WorkhistoryModel = Backbone.Model.extend({
    defaults: {
        person_id: 0,
        company: '',
        address: '',
        nature: '',
        position: '',
        last_salary: '',
        duties: '',
        supervisor_name: '',
        reason_for_leaving: '',
        from_date: '',
        to_date: ''
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/workexperience';
    	} else {
    		return BASE_URL + 'api/workexperience/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var WorkhistoryCollection = Backbone.Collection.extend({
    model: WorkhistoryModel,
});
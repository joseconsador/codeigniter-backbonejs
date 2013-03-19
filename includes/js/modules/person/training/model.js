// --------------------------------------------------------------------
// 
var TrainingModel = Backbone.Model.extend({
    defaults: {
        person_id: 0,
        course: '',
        institution: '',
        from_date: '',
        to_date: '',
        address: '',
        remarks: ''
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/training';
    	} else {
    		return BASE_URL + 'api/training/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var TrainingsCollection = Backbone.Collection.extend({
    model: TrainingModel,
});
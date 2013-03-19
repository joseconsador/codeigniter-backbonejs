// --------------------------------------------------------------------
// 
var TestModel = Backbone.Model.extend({
    defaults: {
        person_id: 0,
        exam_type_id: 0,
        exam_title: '',
        date_taken: '',
        given_by: '',
        location: '',
        score_rating: '',
        result_type_id: '',
        result_attach: '',
        filename: '',
        log_uploads_id: 0,
        attachment: [0],
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/test';
    	} else {
    		return BASE_URL + 'api/test/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var TestCollection = Backbone.Collection.extend({
    model: TestModel,
});
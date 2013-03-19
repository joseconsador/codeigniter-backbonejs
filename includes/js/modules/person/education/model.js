// --------------------------------------------------------------------
// 
var EducationModel = Backbone.Model.extend({
    defaults: {
        person_id: 0,
        school: '',
        date_from: '',
        date_to: '',
        date_graduated: '',
        degree: '',
        honors: '',
        education_level_id: '',
        education_level : ''        
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/education';
    	} else {
    		return BASE_URL + 'api/education/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var EducationCollection = Backbone.Collection.extend({
    model: EducationModel,
});
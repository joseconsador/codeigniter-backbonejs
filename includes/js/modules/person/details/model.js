// --------------------------------------------------------------------
// 
var PersonDetailModel = Backbone.Model.extend({
    defaults: {    
        person_id: 0,
        gender: '',
        birth_date: '',
        birth_place: '',
        civil_status: '',
        spouse_name: '',
        spouse_work: '',
        marriage_date: '',
        children: 0,
        nationality: '',
        height: '',
        weight: '',
        blood_type: ''
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/persondetail';
    	} else {
    		return BASE_URL + 'api/persondetail/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var PersonDetailsCollection = Backbone.Collection.extend({
    model: PersonDetailModel,
});
// --------------------------------------------------------------------
// 
var FamilyModel = Backbone.Model.extend({
    defaults: {
        person_id: 0,
        name: '',
        relationship_id: '',
        relationship: '',
        birth_date: '',
        occupation: '',
        employer: '',
        educational_attainment_id: '',
        educational_attainment: '',
        degree: '',
        emergency_tag: 0,
        emergency_contact: '',
        emergency_address: ''
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/family';
    	} else {
    		return BASE_URL + 'api/family/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var FamilyCollection = Backbone.Collection.extend({
    model: FamilyModel,
});
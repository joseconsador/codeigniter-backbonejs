// --------------------------------------------------------------------
// 
var ReferenceModel = Backbone.Model.extend({
    defaults: {    
        name: '',
        address: '',
        telephone: '',
        occupation: '',
        years_known: '',
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/reference';
    	} else {
    		return BASE_URL + 'api/reference/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var ReferencesCollection = Backbone.Collection.extend({
    model: ReferenceModel,
});
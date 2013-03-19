// --------------------------------------------------------------------
// 
var AffiliationModel = Backbone.Model.extend({
    defaults: {    
        name: '',
        position: '',
        date_joined: '',
        date_resigned: '',        
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/affiliation';
    	} else {
    		return BASE_URL + 'api/affiliation/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var AffiliationsCollection = Backbone.Collection.extend({
    model: AffiliationModel,
});
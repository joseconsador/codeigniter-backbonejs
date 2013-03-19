// --------------------------------------------------------------------
// 
var Person = Backbone.Model.extend({	
    url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/person';
    	} else {
    		return BASE_URL + 'api/person/id/' + this.get('id');
    	}
    }
});
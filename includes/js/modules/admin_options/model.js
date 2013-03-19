// --------------------------------------------------------------------
// Relational
var Options = Backbone.Model.extend({
    idAttribute: 'option_id',
	url: function () {
        if (this.isNew()) {
            //alert("testing if DELETE request was fire");
            return BASE_URL + 'api/options'; 
        } else {
            //alert("another testing if DELETE request was fire" + this.get('option_id'));
            return BASE_URL + 'api/options/id/' + this.get('option_id'); 
        }
    },  
    defaults: {
        'option_code' : '',
        'option': '',
        'inactive' : 0,
        'option_group' : 0,
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: Options});

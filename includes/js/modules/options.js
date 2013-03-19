// --------------------------------------------------------------------
// 
var OptionModel = Backbone.Model.extend({
	idAttribute: 'option_id',
    url: function () {
        return BASE_URL + 'api/admin_options/master';
    }    
});

// --------------------------------------------------------------------
// 
var OptionsCollection = Backbone.Collection.extend({
	model: OptionModel,
	url: function () {
		return BASE_URL + 'api/options';
	},
	parse: function (data) {
		return data.data;
	}
})
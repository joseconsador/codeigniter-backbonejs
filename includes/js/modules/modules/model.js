var ModuleModel = Backbone.Model.extend({
	idAttribute: 'module_id',	
	defaults: {
		enabled: 0
	},
	url: function () {
        if (this.isNew()) {            
            return BASE_URL + 'api/module'; 
        } else {            
            return BASE_URL + 'api/module/id/' + this.id; 
        }
    }
});

var ModuleCollection = Backbone.Collection.extend({
    model: ModuleModel
});
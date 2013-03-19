// --------------------------------------------------------------------
// 
var UserModel = Backbone.Model.extend({	
	idAttribute: 'user_id',
    url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/user/'; 
			} else {
				return BASE_URL + 'api/user/id/' + this.id;
			}
    }    
});

var TypeAheadCollection = Backbone.Collection.extend({model: UserModel});

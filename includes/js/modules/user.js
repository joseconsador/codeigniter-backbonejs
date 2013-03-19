// --------------------------------------------------------------------
// 
var User = Backbone.Model.extend({
    url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/user/'; 
			} else {
				return BASE_URL + 'api/user/id/' + this.get('id');
			}
    }    
});

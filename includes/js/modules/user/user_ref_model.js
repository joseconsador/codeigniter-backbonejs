// --------------------------------------------------------------------
// 
var UserRefModel = Backbone.Model.extend({
    url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/ref'; 
			} else {
				return BASE_URL + 'api/ref/id/' + this.get('id');
			}
    }    
});

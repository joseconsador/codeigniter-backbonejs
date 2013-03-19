// --------------------------------------------------------------------
// 
var ProfileHeaderView = Backbone.View.extend({
	el: '#profile-header',
    template: $("#profile-header-template").html(), 
    render: function () {
    	var tmpl = _.template(this.template); 	
        var that = this;
    	this.model.fetch({
    		success: function(model) {
        		that.$el.html(tmpl(model.toJSON()));
    		}
    	});
    }
});
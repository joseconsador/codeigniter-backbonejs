// --------------------------------------------------------------------
// 

var NoteView = Backbone.View.extend({
	el: $('.yellow-pad'),
	initialize: function() {
		this.render();
	},
	events: {
		"change": "change",
		"blur" : "save"
	},	
	render: function() {
		this.$el.val(this.model.get('note'));
	},
	change: function(e) {
		this.model.set($(e.target).attr('name'), $(e.target).val());
	},
	save: function() {
		this.model.save();
	}
});
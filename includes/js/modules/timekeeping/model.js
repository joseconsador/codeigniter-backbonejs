var TimelogModel = Backbone.Model.extend({
	defaults: {
		'shift': '',
		'time_in': '',
		'time_out': '',
		'lates': 0,
		'undertime': 0,
		'overtime': 0
	},
	url: function () {
		if (this.isNew()) {
			return BASE_URL + 'api/timelog/'; 
		} else {
			return BASE_URL + 'api/timelog/id/' + this.get('id');
		}
	},
});
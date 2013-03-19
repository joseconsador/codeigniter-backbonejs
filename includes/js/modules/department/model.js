var DepartmentModel = Backbone.Model.extend({
	idAttribute: 'department_id',
	url: function () { 
		if (this.isNew()) {
			return BASE_URL + 'api/department/'; 
		} else {
			return BASE_URL + 'api/department/id/' + this.get('department_id');
		}
	},
});
var TodoModel = Backbone.Model.extend({
	idAttribute: 'todo_id',
	defaults: {
		completed: false
	},
	validate: function(attrs) {
		if ($.trim(attrs.description) == '') {
			return 'To-do cannot be empy.';
		}
	},	
	url: function () {
		if (this.isNew()) {
			return BASE_URL + 'api/todo';
		} else {
			return BASE_URL + 'api/todo/id/' + this.id;
		}
	},
});

var TodoCollection = Backbone.Collection.extend({
	model: TodoModel,	
});

var UserTodoCollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + 'api/user/todos';
    },
    model: TodoModel,
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;
        //Normally this.totalPages would equal response.d.__count
        //but as this particular NetFlix request only returns a
        //total count of items for the search, we divide.        
        this.totalPages = Math.ceil(response._count / this.perPage);
        this.totalRecords = response._count;
        return tags;
    }
});


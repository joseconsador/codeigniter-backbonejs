// --------------------------------------------------------------------
// 
var Goal = Backbone.Model.extend({
	idAttribute: 'goal_id',
	defaults: {
		goal_id: 0,
		title: '',
		description: '',
		full_name: '',
		points_earned: 0,
		related_goal_id: 0,
		parent_id: 0,
		target: '',
		involved: [],
		is_owner: false,
		has_children: false
	},
    url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/goal'; 
			} else {
				return BASE_URL + 'api/goal/id/' + this.id
			}
    }    
});

// --------------------------------------------------------------------
// 

var GoalCollection = Backbone.Collection.extend({
    url: function () {
    	var url = BASE_URL + 'api/goals';

        return url + '?' + $.param(this.request_filters);
    },
    request_filters: {
    	parent_id: null,
    },
    model: Goal,
    parse: function (response) {
        var tags = response.data;
        this.totalPages = Math.ceil(response._count / this.perPage);
        this.totalRecords = response._count;
        return tags;
    }    
});


// --------------------------------------------------------------------
// 
var Objective = Backbone.Model.extend({	
	idAttribute: 'goal_item_id',
	defaults: {
		title: '',
		description: '',
		full_name: '',
		points: 0,
		points_earned: 0,
		target_date: '',
		employee_id: 0,
		involved: []
	},	
    url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/goal_objective/'; 
			} else {
				return BASE_URL + 'api/goal_objective/id/' + this.id;
			}
    }    
});

// --------------------------------------------------------------------
// 

var EmployeeObjective = Backbone.Model.extend({	
	idAttribute: 'goal_item_employee_id',
	defaults: {
		goal_item_id: 0,
		employee_id: 0
	},	
    url: function () {
		if (this.isNew()) {
			return BASE_URL + 'api/goal_objective_employee/'; 
		} else {
			return BASE_URL + 'api/goal_objective_employee/id/' + this.id;
		}
    }
});

// --------------------------------------------------------------------
// 

var ObjectiveCollection = Backbone.Collection.extend({
	model: Objective,
	url: function () {
		return BASE_URL + 'api/goal_objective';
	},
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;        
        this.totalPages = Math.ceil(response._count / this.perPage);

        this.totalRecords = response._count;
        return tags;
    }	
});

// --------------------------------------------------------------------
// 
var EmployeeGoalsCollection = Backbone.Collection.extend({
	model: Goal,
	employee_id: 0,
	url: function () {
		return BASE_URL + 'api/employee/goals';
	},
	comparator: function(goal) {
		return -goal.id;
	},
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;        
        this.totalPages = Math.ceil(response._count / this.perPage);

        this.totalRecords = response._count;
        return tags;
    }	
});

// --------------------------------------------------------------------
// 
var GoalObjectivesCollection = Backbone.Collection.extend({
	model: Objective,
	goal_id: 0,
	url: function () {
		return BASE_URL + 'api/goal/id/' + this.goal_id + '/objectives';
	},
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;        
        this.totalPages = Math.ceil(response._count / this.perPage);

        this.totalRecords = response._count;
        return tags;
    }	
});

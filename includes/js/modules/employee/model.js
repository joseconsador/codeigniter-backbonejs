// --------------------------------------------------------------------
// 
var Employee = Backbone.Model.extend({	
	idAttribute: 'employee_id',	
    url: function () {
    	if (this.isNew()) {
        	return BASE_URL + 'api/201';
    	} else {
    		return BASE_URL + 'api/201/id/' + this.id;
    	}
    },
    _person: null,
    person: function () {    	
    	if (this._person == null) {
        	person = new Person({ id: this.get('user_id') });
        	this._person = person;
    	}

    	return this._person;
    }
});

var TypeAheadCollection = Backbone.Collection.extend({model: Employee});

var EmployeeCollection = Backbone.Collection.extend({model: Employee});
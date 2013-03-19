// --------------------------------------------------------------------
// 
var Event = Backbone.Model.extend({	
	idAttribute: 'event_id',
	defaults: function () {
		return {
			event_id: null,
			date_from: new Date(),
			date_to: new Date(),
			description: '',
			location: '',
			title: '',
			whole_day: false,
			color: '#00ff94',
			involved: new Array(),
			is_participant: false
		};
	},
    url: function () {
    	if (this.isNew()) {
        	return BASE_URL + 'api/event';
    	} else {
    		return BASE_URL + 'api/event/id/' + this.id;
    	}
    }    
});

// --------------------------------------------------------------------
// 
var Involved = Backbone.Model.extend({
	idAttribute: 'event_participant_id',
	accepted_status: 1,
	denied_status: 2,
	tentative_status: 3,
	event_source: false,
	defaults: function() {
		return {
			user_id: 0,
			status_id: 0
		};
	},
    url: function () {
    	if (this.isNew()) {
        	return BASE_URL + 'api/event_involved';
    	} else {
    		if (this.event_source) {
    			return BASE_URL + 'api/event_involved/id/' + this.id + '?format=eventSource';
    		} else {
    			return BASE_URL + 'api/event_involved/id/' + this.id;
    		}
    	}
    }	
});

var EventCollection = Backbone.Collection.extend({model: Event});
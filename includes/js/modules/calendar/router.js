var CalendarRouter = Backbone.Router.extend({
	routes: {
        'new-leave' : 'addLeave',
        'new-event' : 'addEvent',
        'event/invite/:id' : 'showEventInvite'
    },
    addLeave: function() {
    	calendarApp.view.activityModal.start = new Date();
    	calendarApp.view.activityModal.end = new Date();
    	calendarApp.view.activityModal.fileForm();
    },
    addEvent: function() {
    	calendarApp.view.activityModal.start = new Date();
    	calendarApp.view.activityModal.end = new Date();
    	calendarApp.view.activityModal.fileEvent();
    },
    showEventInvite: function(id) {
        calendarApp.view.activityModal.showEventInvite(id);
    }
});
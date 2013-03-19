var CalendarEvent = Backbone.Model.extend();

var CalendarEventCollection = Backbone.Collection.extend({	
	url: function() {
		if (this.from == null || this.to == null) {
			this.from = new Date();
			this.from.setDate(1);

			this.to = new Date(this.from.getUTCFullYear(), this.from.getMonth() + 1, 0);
		}

		return BASE_URL + 'api/events?from=' + this.from.valueOf() / 1000 + '&to=' + this.to.valueOf() / 1000;
	},
	from: null,
	to: null,
	shift: null,
	model: CalendarEvent,
	toEventSource: function() {
		var _data = [];
		_.each(this.models, function(model) {
			model.set('allDay', model.get('allday') == '1');
			model.set('start', new Date(model.get('start') * 1000));

			if (!model.get('allDay')) {
				model.set('end', new Date(model.get('end') * 1000));
			}

			model.set('editable', 
				model.get('editable') == '1' || 
				(model.get('type') == 'event' && model.get('is_participant') == false) ||
				(model.get('type') == 'form' && model.get('locked') == false)
			);

			model.set('defaultstart', new Date(model.get('start') * 1000));
		});
		return this.toJSON();
	}
});
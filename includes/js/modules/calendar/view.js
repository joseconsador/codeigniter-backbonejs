var CalendarView = Backbone.View.extend({
	el: $('#calendar'),
	gapi: null,
	gcals: {},
	_form: null,
	_event: null,
	_involved: null,
	colors: {},
	initialize: function() {
		var that = this;

		this._form = this.getFormModel();
		this._event = this.getEventModel();
		this._involved = this.getInvolvedModel();

		this.activityModal = new ActivityModalSelection({
			eventOptions: this.options.eventOptions,
			form: this._form,
			event: this._event,
			involved: this._involved,
			formForm: new FormModalEditView({model: this._form}),
			eventForm: new EventModalEditView({model: this._event}),
			involvedView: new InvolvedModalView({model: this._involved})
		});

		this._form.on('saveSuccess', function() {
			that.$el.fullCalendar('refetchEvents');			
		});		

		this._event.on('saveSuccess', function() {
			that.$el.fullCalendar('refetchEvents');
		});

		this._involved.on('saveSuccess', function() {
			that.$el.fullCalendar('refetchEvents');			
		});

		this._event.on('delete', function() {
			that.$el.fullCalendar('refetchEvents');
		});

		this._form.on('delete', function() {
			that.$el.fullCalendar('refetchEvents');
		});

		$('#gcal-link').on('click', function() {
		    that.set_gcal(
		      new gapi({
		        client_id: '765461111495.apps.googleusercontent.com',
		        client_secret: 'zkrKkAQgws3Jvr4pYHM4LeTg',
		        redirect_url: SECURE_BASE_URL + 'employee/calendar',
		        access_token: null,
		      })
		    );
		});

		this.renderCalendar();
	},
	set_gcal: function(gcal) {
		var that = this;		
		this.gapi = gcal;
		this.gapi.check_auth();
		
		this.gapi.get('calendar', 'colors', null, function(colors) {
			that.colors = colors;

			that.gapi.get(
				'calendar', 
				'users/me/calendarList', 
				{minAccessRole: "owner"}, 
				function(response) {
					that.set_cals(response);
				}
			);					
		});		
	},
	set_cals: function(gcals) {
		var that = this;
		this.gcals = gcals.items;
		this.$el.fullCalendar('addEventSource', 
			function(start, end, callback) {
				if (that.gcals.length > 0) {

					_.each(that.gcals, function(cal) {
						var options = {
							timeMin: start.toJSON(), 
							timeMax: end.toJSON(),
							singleEvents: true
						};

						var gcalEvents = [];

						that.gapi.get('calendar', 'calendars/' + cal.id + '/events', options,
							function(response) {									
								_.each(response.items, function(event) {
									_e = {};

									if (event.start.date != undefined) {
										s = new Date(event.start.date);
										e = new Date(event.end.date);
									} else {
										s = new Date(event.start.dateTime);
										e = new Date(event.end.dateTime);
										_e['allDay'] = false;
									}

									if (event.colorId > 0) {
										color = that.colors.event[event.colorId];
										_e['color'] = color.background;
									}

									_e['start'] = s.valueOf() / 1000;
									_e['end'] = e.valueOf() / 1000;
									_e['title'] = event.summary;
									_e['url'] = event.htmlLink;

									gcalEvents.push(_e);										
								});

								callback(gcalEvents);
							}
						);
					});
				}				
			}
		);
		this.$el.fullCalendar('refetchEvents');
	},
	getInvolvedModel: function() {
		i = new Involved(this.options.eventOptions);
		i.event_source = true;

		return i;
	},	
	getFormModel: function() {
		return new Form(this.options.eventOptions);
	},
	getEventModel: function() {
		return new Event(this.options.eventOptions);
	},
	renderCalendar: function() {
		var that = this;

		this.$el.fullCalendar({
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay, jsEvent) {
				that.activityModal.start = start;
				that.activityModal.end = end;

				that.activityModal.show();
			},
			eventSources: [
				function(start, end, callback) {
					that.collection.from = start;
					that.collection.to   = end;

					that.collection.fetch({success: function() {
						callback(that.collection.toEventSource());					
						}
					});
				}
			],			
			eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {
				var _e;
				if (event.type == 'event') {
					_e = that.getEventModel();
				} else {
					_e = that.getFormModel();
				}

				_e.set(event);				
				_e.set('date_from', event.start.getUTCFullYear() + '-' + (event.start.getMonth() + 1) + '-' + event.start.getDate() + ' ' + event.start.getHours() + ':' + event.start.getMinutes() + ':' + event.start.getSeconds());
				_e.set('whole_day', allDay);

				if (event.end != null) {
					_e.set('date_to', event.end.getUTCFullYear() + '-' + (event.end.getMonth() + 1) + '-' + event.end.getDate() + ' ' + event.end.getHours() + ':' + event.end.getMinutes() + ':' + event.end.getSeconds());
				} else {
					_e.set('date_to', _e.get('date_from'));
				}

				_e.save();			
			},
			eventClick: function(calEvent, jsEvent, view) {
				if (calEvent.type == 'event' || calEvent.type == 'form' || 
					calEvent.type == 'involved_event') {
					if (calEvent.type == 'event') {
						formView  = that.activityModal.options.eventForm;
					} else if (calEvent.type == 'involved_event') {
						formView  = that.activityModal.options.involvedView;
					} else {
						formView  = that.activityModal.options.formForm;
					}

					formView.model.clear();
					formView.model.set(formView.model.defaults());
					formView.model.set(calEvent);

					that.activityModal.formView = formView;	

					that.activityModal.formView.model.set('date_from', calEvent._start);
					if (calEvent._end == null) {
						that.activityModal.formView.model.set('date_to', calEvent._start);
					} else {
						that.activityModal.formView.model.set('date_to', calEvent._end);
					}

					that.activityModal.formView.show();

					return false;
				}

		        if (calEvent.url) {
		            window.open(calEvent.url);
		            return false;
		        }				
			},
			eventResize: function(event) {
				that._event.set(event);				
				that._event.set('date_from', event.start.getUTCFullYear() + '-' + (event.start.getMonth() + 1) + '-' + event.start.getDate() + ' ' + event.start.getHours() + ':' + event.start.getMinutes() + ':' + event.start.getSeconds());

				if (event.end != null) {
					that._event.set('date_to', event.end.getUTCFullYear() + '-' + (event.end.getMonth() + 1) + '-' + event.end.getDate() + ' ' + event.end.getHours() + ':' + event.end.getMinutes() + ':' + event.end.getSeconds());
				} else {
					that._event.set('date_to', that._event.get('date_from'));
				}

				that._event.save();				
			},
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			timeFormat: 'hh(:mm) tt',
		});
	}
});

var ActivityModalSelection = Backbone.View.extend({
	formView: null,
	el: $('#activity-selection-modal'),	
	show: function() {		
		this.$el.modal('show');
	},		
	events: {
		'click #file-form' : 'fileForm',
		'click #file-event' : 'fileEvent'
	},
	fileForm: function() {
		this.$el.modal('hide');
		this.formView = this.options.formForm;
		this.formView.model.set('form_application_id', null);
		this.resetModel();
		this.showForm();
	},
	fileEvent: function() {
		this.$el.modal('hide');
		this.formView = this.options.eventForm;
		this.formView.model.set('event_id', null);
		this.resetModel();
		this.showForm();
	},	
	showEventInvite: function(id) {
		var that = this;
		this.$el.modal('hide');
		this.formView = this.options.involvedView;		
		this.resetModel();

        this.formView.model.id = id;
        this.formView.model.event_source = true;
        this.formView.model.fetch({
            success: function(model) {
                that.formView.show();
            }
        });
	},
	resetModel: function() {
		// Revert values to default to prevent a bug from EventDrop where the model
		// is overridden		
		this.formView.model.clear();
		this.formView.model.set(this.formView.model.defaults());
	},
	// Separated this because in the router we don't need this.$el.modal('hide');
	showForm: function() {
		this.formView.model.set(this.options.eventOptions);
		this.formView.model.set('date_from', this.start);
		this.formView.model.set('date_to', this.end);

		this.formView.show();
	},	
});
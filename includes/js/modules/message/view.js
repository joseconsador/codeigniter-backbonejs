// --------------------------------------------------------------------
// 

var MessagesView = Backbone.View.extend({
	el: $('.messages-ui'),	
	initialize: function() {
		
	},
	events: {
		"shown a[href='#sent']": "showSent",
		"shown a[href='#inbox']": "showInbox",
	},
	getMessage: function(id) {
		message = app.recievedCollection.where({id:id});
    	app.modalMessage.$el.find('.modal-full_name').text(message[0].get('full_name'));
    	app.modalMessage.$el.find('.modal-original-message').text(message[0].get('message'));

    	app.modalMessage.model = new MessageModel({recipient_id: message[0].get('user_id')});
    	app.modalMessage.$el.modal('show');
	},
	showInbox: function() {
		// No need to fetch because there is already a recurring function for
		// notification (notifications.js)
		this.collection = app.recievedCollection;		
		this.tab = 'inbox';

		this.fetch();
	},
	showSent: function() {
		this.collection = app.sentCollection;		
		this.tab = 'sent';
		this.fetch();
	},
	fetch: function() {				
		this.collection.on('reset', this.render, this);
		this.collection.pager();
	}, 
	render: function() {
		window.location.hash = '/' + this.tab;
		$('#' + this.tab + '-table tbody').empty();		
		var that = this;
		_.each(this.collection.models,
			function (message) {
				m = new MessagesTrView({model: message});

				m.template = $('#' + that.tab + '-list-item').html();

				$('#' + that.tab + '-table tbody').append(m.render().el);
			}
			, this);

		$('#' + this.tab + '-table tbody tr').css('cursor', 'pointer');
		$('#' + this.tab + '-table tbody td').addClass(this.tab);
	}
});

// --------------------------------------------------------------------
// 

var MessagesTrView = Backbone.View.extend({
    tagName: "tr",
    className: "message-tr",
    template: $("#message-list-item").html(),
    events: {
    	'click td.inbox': 'getMessage'
    },	
    getMessage: function () {
    	window.location.hash = '/inbox/' + this.model.get('id');
    },
    render: function () {
        var tmpl = _.template(this.template);
        d = this.model.get('created').split(' ');
        date = new Date(d[0]);
        fdate = monthNames[date.getMonth()] + ' ' + date.getDate();
        this.model.set('fdate', fdate);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
// 
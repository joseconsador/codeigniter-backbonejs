$(function() {
	// --------------------------------------------------------------------
	// 	
	var NotificationView = Backbone.View.extend({
		el: $('#notifications-container'),
		messagesLoaded: false,
		unread: 0,
		interval: 10000,
		initialize: function () {
			var that = this;
			this.collection.on('reset', this.updateMessageList, this);
			this.collection.on('change', this.updateMessageList, this);

			this.fetchNotifications();

			setInterval(function () {
				that.fetchNotifications();
			}, that.interval);			
		},
		fetchNotifications: function () {
			var that = this;
			$.ajax({
				url: BASE_URL + 'notifications/get',
				success: function(response) {
					app.messageNotificationView.collection.reset(response.messages.data);
					that.collection.reset(response.notifications.data);
				}
			});
		},
		updateMessageList: function () {
			var unread = this.collection.where({log_read: null});

			if ($(unread).size() != this.unread) {
				this.messagesLoaded = false;
			}
			
			this.unread = $(unread).size();
			
			if (this.unread > 0) {
				this.$el.find('.counter').text(this.unread);
			} else {
				this.$el.find('.counter').empty();
			}
		},
		events: {
			'click a.dropdown-toggle' : 'loadMessages'
		},
		loadMessages: function (e) {
			if (this.unread > 0) {
				unread = this.collection.where({log_read: null});	

				_.each(unread, function (model) {
					model.set('log_read', 1);					
				}, this);

				// Mark messages as read
				$.ajax({
					url: BASE_URL + 'api/notifications',
					type: 'put'					
				});		
			}
		
			if (!this.messagesLoaded) {
				this.$el.find('.dropdown-menu').empty();				
				_.each(this.collection.models, this.renderOne, this);
				this.messagesLoaded = true;
				$("abbr.timeago").timeago();
			}
		},
		renderOne: function (model) {
			i = new NotificationSubView({model: model});
			
			this.$el.find('.dropdown-menu').append(i.render().el);
			this.$el.find('.dropdown-menu').append('<li class="divider"></li>');
		}		
	});	

	// --------------------------------------------------------------------
	// 	
	var MessageNotificationView = Backbone.View.extend({
		el: $('#messages-container'),
		messagesLoaded: false,
		unread: 0,		
		initialize: function () {
			this.collection.on('reset', this.updateMessageList, this);
			this.collection.on('change', this.updateMessageList, this);
		},		
		updateMessageList: function () {
			var unread = this.collection.where({log_read: '0'});

			if ($(unread).size() != this.unread) {
				this.messagesLoaded = false;
			}
			
			this.unread = $(unread).size();
			
			if (this.unread > 0) {
				this.$el.find('.counter').text(this.unread);
			} else {
				this.$el.find('.counter').empty();
			}
		},
		events: {
			'click a.dropdown-toggle' : 'loadMessages'
		},
		loadMessages: function (e) {
			if (this.unread > 0) {
				unread = this.collection.where({log_read: '0'});	

				_.each(unread, function (model) {
					model.set('log_read', 1);					
				}, this);

				// Mark messages as read
				$.ajax({
					url: BASE_URL + 'api/messages',
					type: 'put'					
				});		
			}
		
			if (!this.messagesLoaded) {
				this.$el.find('.dropdown-menu').empty();
				this.$el.find('.dropdown-menu').append('<li class="nav-header">Messages</li>');
				this.$el.find('.dropdown-menu').append('<li class="divider"></li>');
				_.each(this.collection.models, this.renderOne, this);
				this.messagesLoaded = true;
				this.$el.find('.dropdown-menu').append('<li class="nav-header"><a href="' + BASE_URL + 'messages">View all</a></li>');
				$("abbr.timeago").timeago();
			}
		},
		renderOne: function (model) {
			i = new MessageView({model: model});
			
			this.$el.find('.dropdown-menu').append(i.render().el);
			this.$el.find('.dropdown-menu').append('<li class="divider"></li>');
		}
	});	

	// --------------------------------------------------------------------
	// 
	var MessageView = Backbone.View.extend({
	    tagName: "li",
	    template: $("#message-notification-template").html(),
	    render: function () {
	        var tmpl = _.template(this.template); 	        
	        this.$el.html(tmpl(this.model.toJSON()));
	        return this;
	    }
	});  			

	var Notification = Backbone.Model.extend();

	var NotificationsCollection = Backbone.Collection.extend({
		model: Notification
	});

	// --------------------------------------------------------------------
	// 
	var NotificationSubView = Backbone.View.extend({
	    tagName: "li",
	    template: $("#notification-template").html(),
	    render: function () {
	        var tmpl = _.template(this.template); 	        
	        this.$el.html(tmpl(this.model.toJSON()));
	        return this;
	    }
	});  	

	window.recievedMessagesCollection = new RecievedMessagesCollection(dmessages);
	window.app = [];

	$(function(){
		app.recievedCollection = recievedMessagesCollection;
		app.sentCollection = new SentMessagesCollection();
		app.notificationCollection = new NotificationsCollection(dnotifications);		
		app.mainView = new NotificationView({collection: app.notificationCollection});
		app.messageNotificationView = new MessageNotificationView({collection: app.recievedCollection});
		app.modalMessage = new ModalMessageForm();

		Backbone.history.start();
	});	
});	
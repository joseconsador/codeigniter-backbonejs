/**
 * Used in cases where the messaging is from a modal interface.
 */
var ModalMessageForm = Backbone.View.extend({	
	el: $('#modalMessage'),	
	events: {
		'click #message-send' : 'sendMessage',
		'change input,textarea' : 'updateModel'
	},
	updateModel: function (e) {
    	change = {};
    	change[$(e.target).attr('name')] = $(e.target).val();
    	this.model.set(change);  
	},
	sendMessage: function(e) {
		e.preventDefault();		
		var that = this;
		
		$(e.target).text('Sending...').attr('disabled', true);
		
		this.model.save('', '', 
			{
				success: function (model) { 
					// reset the model once saved to prevent PUT requests
					that.model = new MessageModel(
						{
							recipient_id : model.get('recipient_id'),
							message : model.get('message')
						}
					);
					that.$el.find('#messaging-message').removeClass('hidden')
						.removeClass('label-important').addClass('label-success')
						.text('Your message has been sent.');

					$(e.target).text('Send Message').attr('disabled', false);

					setTimeout(function () {
						that.$el.modal('hide');
					}, 1000);
				},
				error: function (model, message) {
					if (typeof(message) === 'object') {
						message = 'Something went wrong..';
					}

					that.$el.find('#messaging-message').removeClass('hidden')
						.removeClass('label-success').addClass('label-important').text(message);

					$(e.target).text('Send Message').attr('disabled', false);
				}
			}
		);
	}	
});
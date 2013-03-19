// --------------------------------------------------------------------
// 

var ThankyouModalForm = Backbone.View.extend({
	el: $('#modalThankyou'),
	events: {
		'click #btn-send' : 'sendThankyou',
		'change input,textarea' : 'updateModel'
	},
	updateModel: function (e) {
    	change = {};
    	change[$(e.target).attr('name')] = $(e.target).val();
    	this.model.set(change);  
	},
	sendThankyou: function(e) {
		e.preventDefault();		
		var that = this;
		
		$(e.target).text('Sending...').attr('disabled', true);
		
		this.model.save('', '', 
			{
				success: function (model) { 
					// reset the model once saved to prevent PUT requests
					that.model = new ThankyouModel(
						{
							recipient_id : model.get('recipient_id'),
							thankyou : model.get('message')
						}
					);
					that.$el.find('#thankyou-message').removeClass('hidden')
						.removeClass('label-important').addClass('label-success')
						.text('Your thank you has been sent.');

					$('#thankyou-button').attr('disabled', true).text('Thanked');

					$(e.target).text('Send Thank You').attr('disabled', false);

					setTimeout(function () {
						that.$el.modal('hide');
					}, 1000);
				},
				error: function (model, thankyou) {
					if (typeof(thankyou) === 'object') {
						thankyou = 'Something went wrong..';
					}

					that.$el.find('#thankyou-message').removeClass('hidden')
						.removeClass('label-success').addClass('label-important').text(thankyou);

					$(e.target).text('Send Thank You').attr('disabled', false);
				}
			}
		);
	}		
});
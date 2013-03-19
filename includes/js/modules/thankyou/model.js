// --------------------------------------------------------------------
// 
var ThankyouModel = Backbone.Model.extend(
	{
		defaults: {
			'recipient_id' : undefined,
			'message' : ''
		},
		validate: function(attrs) {
			if (attrs.recipient_id == undefined) {
				return 'Recipient is empty.';
			}

			if (attrs.message == '') {
				return 'Message is empty.';
			}			
		},		
		url: function () {
			if (this.isNew()) {
				return BASE_URL + 'api/thankyou'; 
			} else {
				return BASE_URL + 'api/thankyou/id/' + this.get('id');
			}
		},
	}
);
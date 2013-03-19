var RewardModel = Backbone.Model.extend({
	idAttribute: 'reward_id',
	defaults: {
		name: '',
		description: '',
		points: '',
		order: '',
		filename: '',
		attachment: [0],
		image_path: ''
	},
	url: function() {
		if (this.isNew()) {
			return BASE_URL + 'api/reward';
		} else {
			return BASE_URL + 'api/reward/id/' + this.id;
		}
	}
});

var RewardsCollection = Backbone.Collection.extend({
	model: RewardModel,
	url: function() {
		return BASE_URL + 'api/rewards';
	},
	parse: function(response) {
		return response.data;
	}	
});
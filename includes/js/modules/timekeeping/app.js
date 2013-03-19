var TimekeepingRouter = Backbone.Router.extend({
	routes: {
        '' : 'default',
    },
    default: function() {

    }
});

var timekeepingApp = {
	_router: null,
	_logsView: null,
	collection: null,
	startRouter: function() {
		if (this._router == null) {
			this._router = new TimekeepingRouter();
		}

		return this._router;
	},
	startView: function() {
		if (this._logsView == null) {
			this._logsView = new LogView({collection:this.collection});
		}

		return this._logsView;
	},
	init: function() {
		this.startRouter();
		this.startView();		
	},
	start: function() {
		
	}
};	
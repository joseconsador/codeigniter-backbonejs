var DepartmentUserModel = Backbone.Collection.extend();

var DepartmentUsersCollection = Backbone.Collection.extend({
	url: function () {
		exclude_id = '';
		if (this.exclude_id != undefined) {
			exclude_id = '?exclude_ids[0]=' + this.exclude_id;
		}

		return BASE_URL + 'api/department/id/' + this.department_id + '/users' + exclude_id;
	},
	parse: function (response) {
		var i = 25;
		if (response._count < 25) {
			i = response._count;
		}
		// response data
		var data = new Array();
		// keep all randomized indexes
		var indexes = new Array();
				
		while (i > 0) {
			n = Math.floor(Math.random() * response._count);

			if ($.inArray(n, indexes) < 0) {
				indexes.push(n);
				data.push(response.data[n]);
				i--;
			}
		}

        this.totalRecords = response._count;

        return data;
	}	
});

var DepartmentUserView = Backbone.View.extend({
	tagName: 'a',
	className: 'label label-info',
	style : 'display: inline',
	attributes: function() {
    	return {
    		'data-content' : '<p>' + this.model.get('company') + '</p><p>' + this.model.get('position') + '</p>',
    		'rel' : 'popover',
		    'href': BASE_URL + 'profile/' + this.model.get('hash'),
		    'data-original-title': this.model.get('full_name'),		    
		    };
	},
    template: $("#depuser-template").html(),
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

var DepartmentUsersView = Backbone.View.extend({
	el: $('#depusers-preview'),
	initialize: function () {
		this.collection.fetch();
		this.collection.on('reset', this.render, this);
	},	
	render: function () {
		this.$el.find('.depuser-count').text(this.collection.totalRecords);
		this.collection.each(this.renderOne, this);
		this.$el.find('.depusers-container').find('a').removeAttr('style');
		$('a[rel*=popover]').popover({placement: get_popover_placement, html: true, trigger: 'hover'});
	},
	renderOne: function (item) {
        var subview = new DepartmentUserView({
            model: item
        });
        
        this.$el.find('.depusers-container').append($(subview.render().el).hide().fadeIn('slow'));
        this.$el.find('.depusers-container').append('\n');
	}
});

var ThankyouUsersView = Backbone.View.extend({
	el: $('.thankyou-container'),
	initialize: function() {
		this.collection.fetch();
		this.collection.on('reset', this.render, this);
	}, 
	render: function () {	
		this.collection.each(this.renderOne, this);
		this.$el.find('.thankyouusers-container').find('a').removeAttr('style');
		$('a[rel*=popover]').popover({placement: get_popover_placement, html: true, trigger: 'hover'});
	},
	renderOne: function (item) {
        var subview = new ThankyouUserView({
            model: item
        });
        
        this.$el.find('.thankyouusers-container').append($(subview.render().el).hide().fadeIn('slow'));
        this.$el.find('.thankyouusers-container').append('\n');
	}	
});

var ThankyouUserView = Backbone.View.extend({
	tagName: 'a',
	className: 'label label-info',
	style : 'display: inline',
	attributes: function() {
    	return {
    		'data-content' : '<p>' + this.model.get('message') + '</p>',
    		'rel' : 'popover',
		    'href': '#',
		    'data-original-title': this.model.get('full_name'),		    
		    };
	},
    template: $("#thankyouuser-template").html(),
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

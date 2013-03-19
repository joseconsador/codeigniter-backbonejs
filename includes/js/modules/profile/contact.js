// --------------------------------------------------------------------
// 
var ContactModel = Backbone.Model.extend({	
	defaults: {
		'contact_type' : 'Home',
		'contact': '',
		'im_tag' : '',
		'is_primary' : false,
		'last' : true,
		'first': true
	},
	url: function () { 
		if (this.isNew()) {
			return BASE_URL + 'api/contact/'; 
		} else {
			return BASE_URL + 'api/contact/id/' + this.get('id');
		}
	},
	validate: function (attrs) {
		if (attrs.contact == '') {
			return 'This field must not be left blank.';
		}
	}
});

// --------------------------------------------------------------------
// 
var ContactCollection = Backbone.Collection.extend({
	model: ContactModel,
	url: BASE_URL + 'api/user/contact'
});

// --------------------------------------------------------------------
// 
var EditContactView = Backbone.View.extend({
	el: $('#myContacts'),
	events: {
		'click #contacts-submit': 'saveCollection'		
	},
	initialize: function() {
		this.render();
	},
	render: function () {
		var that = this;
		var mobile = [];
		var other = [];
		var im = [];
				
		_.each(this.collection.models, function(model) {			
			if (model.get('contact_type') == 'Home' || model.get('contact_type') == 'Fax' || model.get('contact_type') == 'Work') {
				other.push(model);
			} else if (model.get('contact_type') == 'Mobile') {
				mobile.push(model);
			} else {
				im.push(model);
			}
		});

    	if ($(im).size() == 0) {
    		e_model = new ContactModel({contact_type: 'IM'});
    		im.push(e_model);
    		this.collection.push(e_model);
    	}
		
    	if ($(mobile).size() == 0) {
    		e_model = new ContactModel({contact_type: 'Mobile'});
    		mobile.push(e_model);
    		this.collection.push(e_model);
    	}

    	if ($(other).size() == 0) {
    		e_model = new ContactModel();
    		other.push(e_model);
    		this.collection.push(e_model);
    	}

		mobileContactGroup = new ContactGroupEditView({models: mobile, container: 'mobile', collection: this.collection});
		otherContactGroup = new ContactGroupEditView({models: other, container: 'other', collection: this.collection});
		imContactGroup = new ContactGroupEditView({models: im, container: 'im', collection: this.collection});
	},
	saveCollection: function (e) {
		var that = this;
		this.valid = true;

		_.each(this.collection.models, function(model) {
			if (!model.isValid()) {this.valid = false;}
		}, this);

		if (this.valid) {
			var ctr = 0;
			_.each(this.collection.models, function(model) {				
				$(e.target).text('Saving...').attr('disabled', true);
				model.save('','',{					
					success: function () {
						that.closeDialog(++ctr);
					},
					wait: true
				});
			}, this);
		}
	},
	closeDialog: function (c) {
		if (c == this.collection.length) {
			this.$el.modal('hide');
			$('#contacts-submit').text('Submit Changes').attr('disabled', false);

			im_primary = this.collection.where({is_primary: true, contact_type: 'IM'});

			if ($(im_primary).size() == 0) {
				// Just get first contact to prevent js error
				im_primary = this.collection.where({contact_type: 'IM'});            
			}

			if ($(im_primary).size() > 0) {
				$('#im-primary').text(im_primary[0].get('contact'));
			}

			mobile_primary = this.collection.where({is_primary: true, contact_type: 'Mobile'});

			if ($(mobile_primary).size() == 0) {
				mobile_primary = this.collection.where({contact_type: 'Mobile'});
			}

			if ($(mobile_primary).size() > 0) {          
				$('#mobile-primary').text(mobile_primary[0].get('contact'));
			}			
		}
	}
});

// --------------------------------------------------------------------
// 
var ContactGroupEditView = Backbone.View.extend({
	tagName: "div",
	initialize: function () {		
		this.render();		
	},
	events: {
		'click .add-new': 'addNew'		
	},	
	addNew: function (event) {		
		model = new ContactModel({
			last: true, 
			first: false,
			contact_type: $(event.target).parent().attr('rel')
			}
		);

		if (model.get('contact_type') == 'IM') {
			model.set('im_tag', 'AIM');
		}

		this.options.models.push(model);
		this.collection.models.push(model);

		this.render();		
	},
    render: function () {    	
    	this.count = $(this.options.models).size();

    	this.$el = $('#container-' + this.options.container);

    	var that = this;

    	this.$el.empty();

    	$.each(this.options.models, function(index, model) {    		
    		if (index == 0) {
    			model.set('first', true);
    		} else {    			
    			model.set('first', false);
    		}

    		if (index + 1 == that.count) {
    			model.set('last', true);
    		} else {
    			model.set('last', false);
    		}

    		var contactEditView = new ContactItemEditView(
    			{
    				model: model, 
    				collection: this.collection,
    				container: that.options.container
    			}
    		);
    		
    		that.$el.append(contactEditView.render().el);
    	});

    	return this;
    }
});

// --------------------------------------------------------------------
// 
var ContactItemEditView = Backbone.View.extend({	
    tagName: "div",    
    events: {
    	'change input[type!="radio"],select': 'change',
    	'click input[type="radio"]': 'changePrimary'
    },
    initialize: function () {
    	var that = this;
    	this.model.on('error', function (model, error) {
			var tmpl = _.template($('#alert-template').html());
			that.$el.find('.controls').after(tmpl({message: error}));
		});
    },
    changePrimary: function () {
    	var that = this;
    	this.model.set('is_primary', true);     	
    	// Set all models to not primary.		
		_.each(_.filter(this.collection.models, function(model) {
				return model.get('contact_type') == that.model.get('contact_type') 
					&& model.get('id') != that.model.get('id');
			}),
			function(model) {								
				model.set('is_primary', false, {silent: true});
			}
		);    	
    },
    change: function (e) {
    	change = {};
    	change[$(e.target).attr('name')] = $(e.target).val();    	    	
    	this.model.set(change, {silent:true});    	
    	//this.model.set(change);
    },
    render: function () {
    	this.template = $('#' + this.options.container + '-input-template').html(); 
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});
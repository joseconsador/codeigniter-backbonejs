var RewardShopView = Backbone.View.extend({
	el: $('#rewards-container'),
	initialize: function() {
		var that = this;
		this.modalEdit = new RewardModalEditView();
		this.modalEdit.model = new RewardModel();		

		this.collection.on('reset', this.render, this);	

        $('#add-reward').on('click', function() { that.showAddForm(); });
	},		
	render: function() {
		var ctr = 0;

		this.$el.find('#rewards-list').empty();

		_.each(this.collection.models, function(model) {
			if (ctr == 4 || ctr == 0) {				
				this.$el.find('#rewards-list').append('<ul class="thumbnails thumbrow"></ul>');
				ctr = 0;
			}

			this.renderOne(model);
			ctr++;
		}, this);		
	},
	renderOne: function(reward) {
		var that = this;
		view = new RewardShopItemView({model: reward});

		this.$el.find('#rewards-list ul.thumbnails').last().append(view.render().el);
		view.$el.find('.edit').on('click', function() {
			that.modalEdit.model = reward;
			that.modalEdit.show();
		});

		reward.on('save', function(e) { this.collection.fetch(); }, this);
		reward.on('delete', function(e) { this.collection.fetch(); }, this);
	},
	showAddForm: function () {
		var that = this;
		this.modalEdit.model = new RewardModel({reward_id: undefined});

		this.modalEdit.model.on('save', function(e) {
			that.collection.fetch();
		});

		this.modalEdit.show();
	}	
});

var RewardShopItemView = Backbone.View.extend({	
    events: {
        'click .redeem' : 'redeem'
    },
	tagName: 'li',
	className: 'span3',
	template: $('#reward-list-item-template').html(),
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    },
    redeem: function() {
        $.ajax({
            url: BASE_URL + 'api/reward/id/' + this.model.id + '/redeem',
            type: 'post'
        });
    }    
});

// --------------------------------------------------------------------
//
var RewardEditView = Backbone.View.extend({
    template: $('#reward-edit-template').html(),
    events: {
        "click #reward-send": "saveReward",
        "click .delete": "delete"    
    },    
    delete: function() {
        var that = this;
        $('#reward-delete').on('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {                
                that.model.destroy({success: function (model, response) {                	
                    that.model.trigger('delete');
                    }
                });   
            });
        })
        .modal();
    },
    show: function() {
        var that = this;
    	this.render();
    },
    render: function () {
        var tmpl = _.template(this.template);
        vars = this.model.toJSON();

        this.$el.html(tmpl(vars));

        return this;
    },
    saveSuccess: function() {

    },
    saveError: function() {

    },
    saveReward: function(e) {        
        e.preventDefault();
        $('.label-important').remove();
        $(e.target).attr('disabled', true).text('Saving...');

        var that = this;

        this.$el.find('input[name="file_attachment"]')
            .fileupload('send', { files: this.model.get('attachment') })
            .success(function(result) {                
                $(e.target).removeAttr('disabled').text('Save Reward');
                that.saveSuccess();
                that.model.trigger('save');                
            })
            .error(function(xhr, textStatus, errorThrown) {
                $(e.target).text('Save').removeAttr('disabled');

                response = $.parseJSON(xhr.responseText);

                $.each(response.message, function(field, error) {                   
                    errors = _.values(error).join(', ');

                    $('#' + field).after('<span class="label label-important">' + errors + '</span>');
                });

                that.saveError();              
            });
    }
});

// --------------------------------------------------------------------
//
var RewardModalEditView = RewardEditView.extend({
    el: $('#reward-edit-modal'),
    class: 'row-fluid',
    template: $('#reward-edit-modal-template').html(),
    rewards: [],
    filter: null,
    show: function() {
        this.render();
        this.$el.modal('show');
    },
    saveSuccess: function() {
        if (this.model.isNew()) {
            message = 'Reward added.';
        } else {
            message = 'Reward updated.';
        }

        this.$el.find('.modal-footer .label-success').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-success">' + message +'</span>');
    },
    saveError: function() {
        this.$el.find('.modal-footer .label-important').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-important">Please correct the errors.</span>');
    },
    render: function() {
    	var that = this;
        var view_data = this.model.toJSON();
        editView = new RewardEditView({model: this.model});

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        view_data.edit_form = _e.html();

        if (this.model.isNew()) {
            view_data.header = 'Add new Reward';
        } else {
            view_data.header = 'Edit reward: "' + this.model.get('name') + '"';
        }

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(view_data));      

        this.model.on('delete', function() {
        	this.$el.modal('hide');
        }, this);

        this.$el.find('input[name="file_attachment"]').fileupload({
            url: that.model.url(),
            add: function(event, data) {
                $(event.target).parent().siblings('.label').text(data.files[0].name);
                // Attach the file object to the model so that we can access it on the save
                // function above
                that.model.set('attachment', data.files);
            }            
        });        
    },
});
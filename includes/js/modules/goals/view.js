// --------------------------------------------------------------------
// 
var GoalsContainerView = Backbone.View.extend({
	el: '#goals-container',
	modalEdit: null,
	modalObjectiveEdit: null,
    filter: null,
	initialize: function() {
		var that = this;
        this.subordinates = this.options.subordinates;
		this.modalEdit = new GoalModalEditView();

		this.modalEdit.model = new Goal();

		this.modalObjectiveEdit = new GoalObjectiveModalEditView();
        this.modalObjectiveEdit.subordinates = this.options.subordinates;

		this.collection.on('reset', this.render, this);	

        $('#add-goal-btn').on('click', function() { that.showAddGoalForm(); });
	},
    clearSidenav: function() {
        $('#created-goals-list li').not('.nav-header').empty();
        $('#my-goals-list li').not('.nav-header').empty();
    },
    addToSidebar: function(goal) {
        item = '<li><a class="goal-filter" href="#" rel="' + goal.id + '">' + goal.get('title') + '</a></li>';

        if (goal.get('is_owner')) {
            $('#created-goals-list').append(item);
        } else {
            $('#my-goals-list').append(item);
        }
    }, 
	render: function() {
        var that = this;
		this.clearSidenav();
        _.each(this.collection.models, this.addToSidebar);

        $('#goals-list').empty();

        models = this.getFilter();

        this.modalEdit.goals = this.collection.models;

		_.each(models, this.renderOne, this);        

        $('.goal-filter').die().live('click', function(e) {
            that.filter = $(e.target).attr('rel');
            that.modalEdit.filter = that.filter;
            that.render();
        });
	},
	renderOne: function(goal) {
		view = new GoalView({
			model: goal,
			modalObjectiveEdit: this.modalObjectiveEdit,
            subordinates: this.subordinates
		});

		view.modalEdit = this.modalEdit;
		this.$el.find('#goals-list').append($(view.render().el));

		goal.on('save', function(e) { this.collection.fetch(); }, this);
		goal.on('delete', function(e) { this.collection.fetch(); }, this);

        $('.star').rating();

        if (!goal.get('is_owner')) {
            view.$el.find('.star').rating('readOnly',true);
        }
	},
    getFilter: function() {
        if (this.filter > 0) {            
            /*var models = this.collection.where({goal_id: this.filter});
            models = models.concat(this.collection.where({parent_id: this.filter}));
*/
            return this.collection.where({goal_id: this.filter});
        }

        return this.collection.models;
    },
	showAddGoalForm: function () {
		var that = this;
		this.modalEdit.model = new Goal({
			employee_id: this.options.employee_id,
			full_name: this.options.full_name,
			goal_id: null
		});

		this.modalEdit.model.on('save', function(e) {
			that.collection.fetch();
		});

		this.modalEdit.show();
	}
});

// --------------------------------------------------------------------
// 
var GoalView = Backbone.View.extend({
	template: $('#goal-list-item-template').html(),
	className: 'well goals-box',
	events: {
		'click .delete': 'delete',		
        'click .goal-point': 'setPoints',
        'click .rating-cancel a': 'clearPoints',
        'click .show-children': 'showChildren'
	},
	modalEdit: null,
	modalObjectiveEdit: null,
    childCollection: null,
	initialize: function() {
		this.modalObjectiveEdit = this.options.modalObjectiveEdit;

        if (this.model.get('has_children')) {
            this.childCollection = new GoalCollection();                
        }
	},
    clearPoints: function(e) {
        this.model.save('points_earned', 0, {
            success: function(model) {
                model.trigger('save');
            }
        });
    },
    setPoints: function(e) {
        if (this.model.get('is_owner') == false) {
            return;
        }

        this.model.save('points_earned', $(e.target).attr('title'), {
            success: function(model) {
                model.trigger('save');
            }
        });
    },
	delete: function () {
		alert('delete');
	},
	edit: function () {
        if (this.model.get('is_owner')) {
    		this.modalEdit.model = this.model;
    		this.modalEdit.show();
        }
	},
	attributes: function() {
		return {style: 'background-color: ' + this.model.get('color') + ' !important'};
	},
	render: function() {
		var that = this;

		var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));

        _.each(this.model.get('items'), function (item) {
        	item = new Objective(item);
        	goalObjectiveView = new ObjectiveView({model: item});

			that.modalObjectiveEdit.goal  = that.model;

        	goalObjectiveView.modalEdit = that.modalObjectiveEdit;            

        	that.$el.find('table tbody').append(goalObjectiveView.render().el);

        	item.on('save', function(e) { that.model.trigger('save'); });
        });

        this.$el.find('#edit-goal-' + this.model.id).on('click', 
            function() { that.edit(); });

        this.$el.find('#add-objective-' + this.model.id).on('click', 
            function() { that.addObjective(); });
        return this;
	},
	addObjective: function () {
		var that = this;

		this.modalObjectiveEdit.model = new Objective({goal_id: this.model.id});
		this.modalObjectiveEdit.goal  = this.model;

		this.modalObjectiveEdit.model.on('save', function(e) {
			that.model.trigger('save');
		});

		this.modalObjectiveEdit.show();
	},
    showChildren: function(e) {
        var that = this;

        if (e !== undefined) {
            $(e.target).attr('disabled', 'disabled');
        }

        this.childCollection.request_filters['parent_id'] = this.model.id;
        
        this.childCollection.fetch({
            success: function(collection) {                
                that.$el.append('<div class="well child-container"></div>');
                _.each(collection.models, function(goal) {
                    view = new GoalView(
                        {
                            model: goal,
                            modalObjectiveEdit: that.modalObjectiveEdit,
                            subordinates: that.subordinates,                            
                        }
                    );

                    view.modalEdit = that.modalEdit;
                    view.model.on('save', function() {                        
                        that.showChildren();
                    });

                    that.$el.find('.child-container').append(view.render().el);

                    $('.star').rating({
                        readOnly: !goal.get('is_owner')
                    });                    
                });

                init_datepicker();
            }
        });
    }
});

// --------------------------------------------------------------------
//
var GoalEditView = Backbone.View.extend({
    goals: [],
    template: $('#goal-edit-template').html(),
    filter: null,
    events: {
        "click #goal-send": "saveGoal",
        "click .delete": "delete"    
    },    
    delete: function() {
        var that = this;
        $('#goal-delete').on('show', function () {
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
    	this.render();

        init_datepicker();
    },
    render: function () {
        var tmpl = _.template(this.template);
        vars = this.model.toJSON();
        vars.goals = this.goals;

        if (this.model.isNew() && this.filter != null) {
            vars.parent_id = this.filter;
        }        

        this.$el.html(tmpl(vars));

        return this;
    },
    saveSuccess: function() {
        alert('parent');
    },
    saveError: function() {

    },
    saveGoal: function(e) {        
        e.preventDefault();
        $('.label-important').remove();
        $(e.target).attr('disabled', true).text('Saving...');

        var that = this;
        var d = new Array();

        $.map(this.$el.find('form').serializeArray(), function(n, i) {
            d[n['name']] = n['value'];
        });

        this.model.save(d, {
            success: function(model, response, options) {                
                $(e.target).removeAttr('disabled').text('Save Goal');
                that.saveSuccess();
                that.model.trigger('save');
            },
            error: function(model, xhr) {
                $(e.target).text('Save').removeAttr('disabled');

                response = $.parseJSON(xhr.responseText);

                $.each(response.message, function(field, error) {                   
                    errors = _.values(error).join(', ');

                    $('#' + field).after('<span class="label label-important">' + errors + '</span>');
                });

                that.saveError();
            }
        });
    }
});

// --------------------------------------------------------------------
//
var GoalModalEditView = GoalEditView.extend({
    el: $('#goal-edit-modal'),
    class: 'row-fluid',
    template: $('#goal-edit-modal-template').html(),
    goals: [],
    filter: null,
    show: function() {
        this.render();
        this.$el.modal('show');
    },
    saveSuccess: function() {
        if (this.model.isNew()) {
            message = 'Goal added.';
        } else {
            message = 'Goal updated.';
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
        editView = new GoalEditView({model: this.model});
        editView.goals = this.goals;
        editView.filter = this.filter;

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        view_data.edit_form = _e.html();

        if (this.model.isNew()) {
            view_data.header = 'Add new Goal';
        } else {
            view_data.header = 'Edit goal: "' + this.model.get('title') + '"';
        }

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(view_data));

        init_datepicker();        

        this.model.on('delete', function() {
        	this.$el.modal('hide');
        }, this);
    },
});
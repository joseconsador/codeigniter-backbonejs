var ModulesListView = Backbone.View.extend({
	el: $('#modules-table'),
	initialize: function() {        
        this.modalEdit = new ModuleModalEditView();
	},
	render: function() {
		_.each(this.collection.models, this.renderOne, this);
	},
	renderOne: function(module) {
		var that = this;
		view = new ModuleListItemView({model: module});

		this.$el.find('tbody').append(view.render().el);
		view.$el.find('.edit').on('click', function() {
			that.modalEdit.model = module;
			that.modalEdit.show();
		});
	}
});

var ModuleListItemView = Backbone.View.extend({
	tagName: 'tr',
	events: {
		'click input[type="checkbox"]' : 'toggleStatus'
	},
	template: $('#module-list-item-template').html(),
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    },
    toggleStatus: function(e) {
    	this.model.save('enabled', $(e.target).is(':checked'));
    }
});


// --------------------------------------------------------------------
//
var ModuleEditView = Backbone.View.extend({    
    template: $('#module-edit-template').html(),
    events: {
        "click #module-send": "saveModule",
        "click .delete": "delete"    
    },    
    delete: function() {
        var that = this;
        $('#module-delete').on('show', function () {
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
    saveModule: function(e) {        
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
                $(e.target).removeAttr('disabled').text('Save Module');
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
var ModuleModalEditView = ModuleEditView.extend({
    el: $('#module-edit-modal'),
    class: 'row-fluid',
    template: $('#module-edit-modal-template').html(),    
    filter: null,
    show: function() {
        this.render();
        this.$el.modal('show');
    },
    saveSuccess: function() {
        if (this.model.isNew()) {
            message = 'Module added.';
        } else {
            message = 'Module updated.';
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
        editView = new ModuleEditView({model: this.model});

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        view_data.edit_form = _e.html();

        if (this.model.isNew()) {
            view_data.header = 'Add new Module';
        } else {
            view_data.header = 'Edit module: "' + this.model.get('name') + '"';
        }

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(view_data));      

        this.model.on('delete', function() {
        	this.$el.modal('hide');
        }, this);
    },
});
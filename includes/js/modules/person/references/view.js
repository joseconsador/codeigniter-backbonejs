// --------------------------------------------------------------------
//
// References
// 
// --------------------------------------------------------------------

// --------------------------------------------------------------------
//

var ReferencesListView = Backbone.View.extend({    
    el: '#references-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new ReferenceListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//
/** @type object Renders and handles the <tr> for the employee list view */
var ReferenceListItemView = Backbone.View.extend({    
    template: $('#reference-item-template').html(),
    tagName: 'tr',
    events: {
        "click .btnedit" : "edit",
        "click .btndelete" : "delete",
    },
    edit: function() {
        this.trigger('edit');        
    },
    delete: function() {
        var that = this;        
        $('#reference-delete').on('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {                
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM                
                    that.remove();
                    that.trigger('delete');
                    }
                });   
            });
        })
        .modal();        
    },
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));

        return this;
    }
});

// --------------------------------------------------------------------
//

var ReferenceListView = Backbone.View.extend({    
    el: '#references-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new ReferenceListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/**
 * Renders and controls the main table
 * @type {[type]}
 */
var ReferencesListEditView = Backbone.View.extend({    
    el: '#references',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#references"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#references">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#references">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#references-table thead tr').append('<th>Actions</th>');
    },
    render: function () {
        $('#references-table tbody').empty();        
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: true});
        view = new ReferenceListItemView({model: item});
        $('#references-table tbody').append(view.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Reference removed.</span>');
        }, this);
    },   
    events: {
        'click .addbtn': 'add',
        'click .btn-cancel': 'cancel',
        'click .btn-primary': 'save'
    },
    cancel: function () {
        this.$el.find('.actions').hide();
        this.$el.find('.addbtn').show();
        this.editView.remove();
    },
    save: function (e) {
        $(e.target).attr('disabled', true).text('Saving...');
        var that = this;
        this.editView.model.save('','', {
            success: function (model) {
                that.collection.add(model, {merge: true});
                $(e.target).removeAttr('disabled').text('Save');
                that.cancel();
                that.render();
                that.$el.find('.form-container').html('<span class="label label-success">Changes saved.</span>');
            }
        });
    },
    add: function (e) {
        this.showForm(new ReferenceModel({person_id: this.options.person_id}));
    },  
    showForm: function(model) {
        this.$el.find('.addbtn').hide();
        this.$el.find('.actions').show();

        this.editView = new ReferencesEditItemView();        
        this.editView.model = model;

        this.$el.find('.form-container').html(this.editView.render().el);
        this.$el.find('.form-container input:first').focus();
    },
    editView: null
});

// --------------------------------------------------------------------
//

var ReferencesEditItemView = Backbone.View.extend({
    tagName: 'div',
    className: 'well',
    template: $('#edit-reference-template').html(),
    events: {
        'change input': 'change'
    },
    change: function(e) {
        change = {};
        change[$(e.target).attr('name')] = $(e.target).val();             
        this.model.set(change);
    },     
    render: function () {
        var tmpl = _.template(this.template);               
        this.$el.html(tmpl(this.model.toJSON()));

        return this;
    }
});
// --------------------------------------------------------------------
//
// Affiliations
// 
// --------------------------------------------------------------------

// --------------------------------------------------------------------
//

var AffiliationsListView = Backbone.View.extend({    
    el: '#affiliations-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new AffiliationListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//
/** @type object Renders and handles the <tr> for the employee list view */
var AffiliationListItemView = Backbone.View.extend({    
    template: $('#affiliation-item-template').html(),
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
        $('#affiliation-delete').on('show', function () {
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

var AffiliationListView = Backbone.View.extend({    
    el: '#affiliations-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new AffiliationListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/**
 * Renders and controls the main table
 * @type {[type]}
 */
var AffiliationsListEditView = Backbone.View.extend({    
    el: '#affiliations',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#affiliations"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#affiliations">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#affiliations">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#affiliations-table thead tr').append('<th>Actions</th>');
    },
    render: function () {
        $('#affiliations-table tbody').empty();        
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: true});
        view = new AffiliationListItemView({model: item});
        $('#affiliations-table tbody').append(view.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Affiliation removed.</span>');
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
        this.showForm(new AffiliationModel({person_id: this.options.person_id}));
    },  
    showForm: function(model) {
        this.$el.find('.addbtn').hide();
        this.$el.find('.actions').show();

        this.editView = new AffiliationEditItemView();        
        this.editView.model = model;

        this.$el.find('.form-container').html(this.editView.render().el);
        this.$el.find('.form-container input:first').focus();
        
        var that = this;

        $('.datepicker').each(function(index, e) {
            var alt = that.$el.find('.form-container input[name="' + $(e).attr('rel') + '"]');
            $(e).datepicker({
                altField : alt,
                altFormat: "yy-mm-dd",
                onSelect: function(dateText, inst) {
                    alt.trigger('change');
                }
            });

            $(e).datepicker("setDate", new Date(alt.val()));
        });               
    },
    editView: null
});

// --------------------------------------------------------------------
//

var AffiliationEditItemView = Backbone.View.extend({
    tagName: 'div',
    className: 'well',
    template: $('#edit-affiliation-template').html(),
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
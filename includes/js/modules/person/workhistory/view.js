

// --------------------------------------------------------------------
//
// Work History
// 
// --------------------------------------------------------------------
 
var WorkhistorysModalEditView = Backbone.View.extend({
    el: $('#tab-work'),
    initialize: function () {
        this.collection.on('reset', this.renderAll, this);
        this.collection.on('add', this.renderAll, this);
    },
    renderAll: function () {
        this.$el.empty();
        var that = this;
        _.each(this.collection.models, function(model) {            
            view = new WorkhistorysModalEditItemView({model: model});            
            that.$el.append(view.render().el);
        });

        var button = new AddMoreButton({collection: this.collection});
        this.$el.append(button.render().el);
    }
});

// --------------------------------------------------------------------
//

var WorkhistoryEditItemView = Backbone.View.extend({
	tagName: 'div',
    className: 'well',
    template: $('#edit-workhistory-template').html(),
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

// --------------------------------------------------------------------
//

var WorkhistoryListView = Backbone.View.extend({    
    el: '#workhistory-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new WorkhistoryListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/** @type object Renders and handles the <tr> for the employee list view */
var WorkhistoryListItemView = Backbone.View.extend({
    template: $('#workhistory-item-template').html(),
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
        $('#work-delete').on('show', function () {
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

var WorkhistoryListItemSubView = Backbone.View.extend({
    tagName: 'tr',
    template: $('#workhistory-item-sub-template').html(), 
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));        
        return this;
    }
});


// --------------------------------------------------------------------
//

/**
 * Renders and controls the main table
 * @type {[type]}
 */
var WorkhistoryListEditView = Backbone.View.extend({    
    el: '#workhistory',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#workhistory"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#workhistory">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#workhistory">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#workhistory-table thead tr').append('<th>Actions</th>');
    },
    render: function () {
        $('#workhistory-table tbody').empty();        
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: true});
        view = new WorkhistoryListItemView({model: item});
        var subview = new WorkhistoryListItemSubView({model: item});

        $('#workhistory-table tbody').append(view.render().el).append(subview.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Work experience removed.</span>');
            subview.remove();
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
        this.showForm(new WorkhistoryModel({person_id: this.options.person_id}));
    },  
    showForm: function(model) {
        this.$el.find('.addbtn').hide();
        this.$el.find('.actions').show();

        this.editView = new WorkhistoryEditItemView();        
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

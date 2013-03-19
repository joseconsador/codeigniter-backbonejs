// --------------------------------------------------------------------
//
// Family
// 
// --------------------------------------------------------------------
 
// --------------------------------------------------------------------
//

var FamilyEditItemView = Backbone.View.extend({
	tagName: 'div',
    className: 'well',
    template: $('#edit-family-template').html(),
    events: {
        'change input,select': 'change'        
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

var FamilyListView = Backbone.View.extend({    
    el: '#family-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new FamilyListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/** @type object Renders and handles the <tr> for the employee list view */
var FamilyListItemView = Backbone.View.extend({
    template: $('#family-item-template').html(),
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
        $('#family-delete').on('show', function () {
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

var FamilyListItemSubView = Backbone.View.extend({
    tagName: 'tr',
    template: $('#family-item-sub-template').html(), 
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
var FamilyListEditView = Backbone.View.extend({    
    el: '#family',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#family"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#family">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#family">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#family-table thead tr').append('<th>Actions</th>');
    },
    relationshipTypes: null,
    educationTypes: null,
    render: function () {
        $('#family-table tbody').empty();

        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: true});

        view = new FamilyListItemView({model: item});
        var subview = new FamilyListItemSubView({model: item});

        $('#family-table tbody').append(subview.render().el).append(view.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Family member removed.</span>');
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
        this.showForm(new FamilyModel({
            person_id: this.options.person_id,
            educationTypes: this.educationTypes,
            relationshipTypes: this.relationshipTypes
            })
        );
    },  
    showForm: function(model) {
        var that = this;
        if (that.educationTypes == null) {     
            $.ajax({
                url: BASE_URL + 'api/admin_options/masters?option_group=EDUCATION',
                success: function(response) {
                    that.educationTypes = response.data;

                    if (that.relationshipTypes == null) {
                        $.ajax({
                            url: BASE_URL + 'api/admin_options/masters?option_group=RELATIONSHIP',
                            success: function(response) {
                                that.relationshipTypes = response.data;
                                that._renderForm(model);
                            }
                        });
                    }                    
                }
            });
        } else {
            this._renderForm(model);
        }
    },
    _renderForm: function (model) {
        model.set('educationTypes', this.educationTypes);
        model.set('relationshipTypes', this.relationshipTypes);        

        this.$el.find('.addbtn').hide();
        this.$el.find('.actions').show();

        this.editView = new FamilyEditItemView();        
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
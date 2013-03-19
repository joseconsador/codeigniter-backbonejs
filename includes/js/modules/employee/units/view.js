// --------------------------------------------------------------------
//
// Unit
// 
// --------------------------------------------------------------------
 
var UnitsModalEditView = Backbone.View.extend({
    el: $('#tab-work'),
    initialize: function () {
        this.collection.on('reset', this.renderAll, this);
        this.collection.on('add', this.renderAll, this);
    },
    renderAll: function () {
        this.$el.empty();
        var that = this;
        _.each(this.collection.models, function(model) {            
            view = new UnitsModalEditItemView({model: model});            
            that.$el.append(view.render().el);
        });

        var button = new AddMoreButton({collection: this.collection});
        this.$el.append(button.render().el);
    }
});

// --------------------------------------------------------------------
//

var UnitEditItemView = Backbone.View.extend({
	tagName: 'div',
    className: 'well',
    template: $('#edit-unit-template').html(),
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

var UnitListView = Backbone.View.extend({    
    el: '#unit-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new UnitListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/** @type object Renders and handles the <tr> for the employee list view */
var UnitListItemView = Backbone.View.extend({
    template: $('#unit-item-template').html(),
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
        $('#unit-delete').live('show', function () {
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

var UnitListItemSubView = Backbone.View.extend({
    tagName: 'tr',
    template: $('#unit-item-sub-template').html(), 
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
var UnitListEditView = Backbone.View.extend({    
    el: '#unit',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#unit"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#unit">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#unit">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#unit-table thead tr').append('<th>Actions</th>');
    },
    render: function () {
        $('#unit-table tbody').empty();        
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: true});
        view = new UnitListItemView({model: item});
        var subview = new UnitListItemSubView({model: item});

        $('#unit-table tbody').append(subview.render().el).append(view.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Unit removed.</span>');
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
        // remove error messages if any.        
        this.$el.find('.label-important').remove();
        
        var that = this;
        
        this.editView.$el.find('input[name="file_attachment"]')
            .fileupload('send', { files: this.editView.model.get('attachment') })
            .success(function(result) {                
                that.editView.model.set(result);                
                that.collection.add(that.editView.model, {merge: true});
                $(e.target).removeAttr('disabled').text('Save');
                that.cancel();
                that.render();
                that.$el.find('.form-container').html('<span class="label label-success">Changes saved.</span>');
            })
            .error(function(jqXHR, textStatus, errorThrown) {
                $(e.target).removeAttr('disabled').text('Save');
                
                response = $.parseJSON(jqXHR.responseText);
                $.each(response.message, function(field, error) {                   
                    errors = _.values(error).join(', ');
                    
                    that.$el.find('input[name="'+ field + '"]').parents('div.controls')
                        .append('<span class="label label-important">' + errors + '</span>');
                });                
            });
    },
    add: function (e) {
        this.showForm(new UnitModel({employee_id: this.options.employee_id}));
    },  
    showForm: function(model) {
        this.$el.find('.addbtn').hide();
        this.$el.find('.actions').show();

        this.editView = new UnitEditItemView();        
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

        this.editView.$el.find('input[name="file_attachment"]').fileupload({
            url: that.editView.model.url(),
            add: function(event, data) {                
                $(event.target).parent().siblings('.label').text(data.files[0].name);                
                // Attach the file object to the model so that we can access it on the save
                // function above
                that.editView.model.set('attachment', data.files);
            }            
        });
    },
    editView: null
});

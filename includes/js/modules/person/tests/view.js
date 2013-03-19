// --------------------------------------------------------------------
//
// Test
// 
// --------------------------------------------------------------------
 
var TestsModalEditView = Backbone.View.extend({
    el: $('#tab-work'),
    initialize: function () {
        this.collection.on('reset', this.renderAll, this);
        this.collection.on('add', this.renderAll, this);
    },
    renderAll: function () {
        this.$el.empty();
        var that = this;
        _.each(this.collection.models, function(model) {            
            view = new TestsModalEditItemView({model: model});            
            that.$el.append(view.render().el);
        });

        var button = new AddMoreButton({collection: this.collection});
        this.$el.append(button.render().el);
    }
});

// --------------------------------------------------------------------
//

var TestEditItemView = Backbone.View.extend({
	tagName: 'div',
    className: 'well',
    template: $('#edit-test-template').html(),
    events: {
        'change input': 'change',
        'change select[name="exam_type_id"]': 'setExamType',
        'change select[name="result_type_id"]': 'setResultType'
    },
    setExamType: function(e) {
        this.model.set('exam_type', $(e.target).find('option:selected').text());
    },
    setResultType: function(e) {
        this.model.set('result', $(e.target).find('option:selected').text());
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

var TestListView = Backbone.View.extend({    
    el: '#test-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new TestListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/** @type object Renders and handles the <tr> for the employee list view */
var TestListItemView = Backbone.View.extend({
    template: $('#test-item-template').html(),
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
        $('#test-delete').on('show', function () {
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

var TestListItemSubView = Backbone.View.extend({
    tagName: 'tr',
    template: $('#test-item-sub-template').html(), 
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
var TestListEditView = Backbone.View.extend({    
    el: '#test',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#test"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#test">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#test">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#test-table thead tr').append('<th>Actions</th>');
    },
    render: function () {
        $('#test-table tbody').empty(); 

        _.each(this.collection.models, this.renderOne, this);
    },
    examTypes: null,
    resultTypes: null,
    renderOne: function (item) {
        item.set({actions: true});
        item.set('examTypes', this.examTypes);        
        view = new TestListItemView({model: item});
        var subview = new TestListItemSubView({model: item});

        $('#test-table tbody').append(subview.render().el).append(view.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Test removed.</span>');
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
        this.showForm(new TestModel({person_id: this.options.person_id}));
    },  
    showForm: function(model) {
        var that = this;
        
        if (this.examTypes == null) {
            $.ajax({
                url: BASE_URL + 'api/admin_options/masters?option_group=EXAM-TYPE',
                success: function(response) {
                    that.examTypes = response.data;
                    
                    if (that.resultTypes == null) {            
                        $.ajax({
                            url: BASE_URL + 'api/admin_options/masters?option_group=RESULT-TYPE',
                            success: function(response) {
                                that.resultTypes = response.data;                                
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
    _renderForm: function(model) {
        this.$el.find('.addbtn').hide();
        this.$el.find('.actions').show();
        model.set('examTypes', this.examTypes);
        model.set('resultTypes', this.resultTypes);
        this.editView = new TestEditItemView({model: model});        

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

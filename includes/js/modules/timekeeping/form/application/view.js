// --------------------------------------------------------------------
// 
var FormView = Backbone.View.extend({
    tagName: "tr",
    events: {
        "click .delete" : "delete",
        "click .approve" : "approve",
        "click .disapprove" : "reject",
    },
    className: "form-container",
    template: $("#form-list-item").html(),    
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    },
    delete: function() {
        var that = this;        
        $('#form-delete').on('show', function () {
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
    approve: function() {
        this.model.changeStatus('approve');   
    },
    reject: function() {
        this.model.changeStatus('reject');   
    }    
});

// --------------------------------------------------------------------
//
var FormEditView = Backbone.View.extend({
    editTemplate: $('#form-edit-form-template').html(),
    viewTemplate: $('#form-view-template').html(),
    events: {
        "click .btn-primary": "saveForm",
        "change input,select,textarea,radio": "change",        
        "click .delete" : "delete"
    },    
    delete: function() {

    },
    form_types: null,
    renderForm: function() {
        var that = this;

        this.render();

        this.$el.find('.datepicker').each(function(index, e) {            
            var alt = that.$el.find('input[name="' + $(e).attr('rel') + '"]');            
            $(e).datepicker({
                altField : alt,
                altFormat: "yy-mm-dd",
                onSelect: function(dateText, inst) {
                    alt.trigger('change');
                },
                beforeShow: function() {
                    // This makes sure the date picker is always on top regardless
                    // of how many modals there are. 
                    // ie. My Calendar
                    setTimeout(function() {
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);                    
                }                
            });

            $(e).datepicker("setDate", new Date(alt.val()));
        }); 

        return this;        
    },
    render: function () {
        var that = this;        

        if (this.model.get('locked')) {
            template = this.viewTemplate;
        } else {
            $.ajax({
                async: false,
                url: BASE_URL + 'api/employee/id/' + this.model.get('employee_id') + '/leavetypes',
                success: function(response) {
                    that.form_types = response.data;                        
                }
            });

            this.model.set('form_types', this.form_types);

            template = this.editTemplate;
        }

        var tmpl = _.template(template);
        this.$el.html(tmpl(this.model.toJSON()));   

        return this;
    },
    change: function(e) {
        this.model.set($(e.target).attr('name'), $(e.target).val());
    }, 
    saveForm: function(e) {
        var that = this;

        e.preventDefault();
        $('.label-important').remove();
        $('.label-success').remove();
        $(e.target).attr('disabled', true).text('Sending...');

        from = this.model.get('date_from');        
        if (typeof(from) == 'object') {
            this.model.set('date_from', from.getUTCFullYear() + '-' + (from.getMonth() + 1) + '-' + from.getDate());
        }

        to = this.model.get('date_to');
        if (typeof(to) == 'object') {        
            this.model.set('date_to', to.getUTCFullYear() + '-' + (to.getMonth() + 1) + '-' + to.getDate());
        }

        this.model.save('', '', {
            success: function(model, response, options) {                
                $(e.target).removeAttr('disabled').text('Update Application');

                that.saveSuccess();
                that.model.trigger('saveSuccess');
            },
            error: function(model, xhr) {
                $(e.target).text('Submit Application').removeAttr('disabled');

                response = $.parseJSON(xhr.responseText);

                $.each(response.message, function(field, error) {                   
                    errors = _.values(error).join(', ');

                    $('#' + field).after('<span class="label label-important">' + errors + '</span>');
                });

                that.model.trigger('saveError');
                that.saveError();
            }
        });
    }
});

// --------------------------------------------------------------------
//
var FormModalEditView = FormEditView.extend({
    el: $('#form-edit-modal'),
    class: 'row-fluid',
    template: $('#form-edit-modal-template').html(),
    initialize: function() {
        
    },
    show: function() {        
        this.renderForm();
        this.$el.modal('show');   
    },
    showForm: function(id) {
        var that = this;
        this.model = new Form();
        this.model.set('form_application_id', id);
        this.model.fetch({
            success: function() {
                that.show();
            }
        });
    },
    saveSuccess: function() {
        this.$el.find('.modal-footer .label-success').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-success">Form successfully filed.</span>');        
    },
    saveError: function() {
        this.$el.find('.modal-footer .label-important').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-important">Please correct the errors.</span>');
    }, 
    delete: function() {
        var that = this;        
        $('#form-delete').on('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {                
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM
                    that.$el.modal('hide');
                    that.$el.on('hidden', function() { model.trigger('delete') });
                    }
                });   
            });
        })
        .modal();
    },    
    render: function() {
        editView = new FormEditView({model: this.model});

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        this.model.set('edit_form', _e.html());

        if (this.model.isNew()) {
            this.model.set('title', 'New Form Type');
        } else {
            this.model.set('title', this.model.get('form'));
        }

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
    },
});
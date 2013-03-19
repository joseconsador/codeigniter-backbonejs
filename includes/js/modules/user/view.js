// --------------------------------------------------------------------
// 
var UserView = Backbone.View.extend({
    tagName: "tr",
    events: {
        "click .delete" : "delete"
    },
    className: "user-container",
    template: $("#user-list-item").html(),    
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    },
    delete: function() {
        var that = this;
        $('#user-delete').on('show', function () {
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
});

// --------------------------------------------------------------------
//
var UserEditView = Backbone.View.extend({
    template: $('#user-edit-form-template').html(),
    events: {
        "click .btn-primary": "saveUser",
        "change input,select,textarea,radio": "change",        
    },    
    civil_status_types: null,
    employment_statuses: null,
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));   

        return this;
    },
    change: function(e) {
        this.model.set($(e.target).attr('name'), $(e.target).val());
    }, 
    saveSuccess: function() {
        alert('parent');
    },
    saveError: function() {

    },
    saveUser: function(e) {        
        e.preventDefault();
        $('.label-important').remove();
        $(e.target).attr('disabled', true).text('Saving...');
        var that = this;
        this.model.save('', '', {
            success: function(model, response, options) {                
                $(e.target).removeAttr('disabled').text('Save');
                that.saveSuccess();
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
var UserModalEditView = UserEditView.extend({
    el: $('#user-edit-modal'),
    class: 'row-fluid',
    template: $('#user-edit-modal-template').html(),    
    show: function() {        
        this.render();
        this.$el.modal('show');
    },
    saveSuccess: function() {
        this.$el.find('.modal-footer .label-success').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-success">User saved.</span>');
    },
    saveError: function() {
        this.$el.find('.modal-footer .label-important').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-important">Please correct the errors.</span>');
    },
    render: function() {
        editView = new UserEditView({model: this.model});

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        this.model.set('edit_form', _e.html());

        if (this.model.isNew()) {
            this.model.set('title', 'New User');
        } else {
            this.model.set('title', this.model.get('form'));
        }

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
    },
});
var sep = '####';
// --------------------------------------------------------------------
// 
var ObjectiveView = Backbone.View.extend({
    template: $('#goal-objective-template').html(),
    tagName: 'tr',  
    events: {
        'click .objective-delete': 'delete',
        'click .objective-edit': 'edit',
        'click .objective-point': 'setPoints',
        'click .rating-cancel a': 'clearPoints'
    },
    clearPoints: function(e) {
        this.model.save('points_earned', 0, {
            success: function(model) {
                model.trigger('save');
            }
        });
    },
    setPoints: function(e) {
        this.model.save('points_earned', $(e.target).attr('title'), {
            success: function(model) {
                model.trigger('save');
            }
        });
    },    
    delete: function () {
        var that = this;
        $('#objective-delete').on('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {                
                that.model.destroy({success: function (model, response) {                   
                    that.remove();
                    }
                });
            });
        })
        .modal();        
    },
    edit: function () {
        this.modalEdit.model = this.model;
        this.modalEdit.show();
    },
    render: function() {
        var tmpl = _.template(this.template);

        this.$el.html(tmpl(this.model.toJSON()));

        return this;
    }
});


// --------------------------------------------------------------------
//
var GoalObjectiveEditView = Backbone.View.extend({
    template: $('#goal-objective-edit-template').html(),
    events: {
        "click .objective-send": "saveGoal",
        "change input,select,textarea,radio": "change",  
        "click .icon-remove" : "deleteInvolved"              
    },
    deleteInvolved: function(e) {
        this.handleRemoveInvite($(e.target).parent().attr('ref'));
        $(e.target).parent().remove();        
    },    
    show: function() {
    	this.render();
        this.afterShow();
    },
    afterShow: function () {
        var that = this;
        $('.datepicker').each(function(index, e) {
            var alt = that.$el.find('input[name="' + $(e).attr('rel') + '"]');
            $(e).datepicker({
                altField : alt,
                altFormat: "yy-mm-dd",
                onSelect: function(dateText, inst) {
                    alt.trigger('change');
                }
            });

            $(e).datepicker("setDate", new Date(alt.val()));
        });

        $('#search-employee').typeahead({
            source: function (query, process) {
                var data = new Array();

                _.each(that.subordinates, function(subordinate) {
                    data.push(subordinate.employee_id + sep + subordinate.full_name);
                });

                process(data);
            },
            highlighter: function(item) {
                var parts = item.split(sep);
                parts.shift();

                return parts.join(sep);
            },
            updater: function(item) {
                var parts = item.split(sep);
                id = parts.shift();

                involved = that.model.get('involved');

                exists = false;
                $.each(involved, function(idx, i) {
                    if (i.employee_id == id) {
                        exists = true;
                    }
                });

                if (exists) return;

                new_involved = new EmployeeObjective({
                    employee_id: id
                });

                involved.push(new_involved);
                that.model.set('involved', involved);

                var label = $('<a class="label label-info" />')
                    .attr('ref', id)
                    .html('<i class="icon-remove icon-white"></i> ' + parts.join(sep));

                that.$el.find('#involved-container').append(label).append('\n');

                label.find('.icon-remove').on('click', function() {
                    label.remove();
                    that.handleRemoveInvite(label.attr('ref'));
                });
            },            
            minLength: 4
        });                
    },
    handleRemoveInvite: function(employee_id) {
        involved = this.model.get('involved');
        index = -1;
        $.each(involved, function(idx, i) {
            if (i.employee_id == employee_id) {
                index = idx;
            }
        });

        if (index > -1) {
            _i = new EmployeeObjective(involved[index]);
            _i.destroy();
            
            involved.splice(index, 1);

            this.model.set('involved', involved);
        }
    },    
    render: function () {
        var tmpl = _.template(this.template);
        vars = this.model.toJSON();
        vars.subordinates = this.subordinates;
        this.$el.html(tmpl(vars));   

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
    saveGoal: function(e) {
        e.preventDefault();
        $('.label-important').remove();
        $(e.target).attr('disabled', true).text('Saving...');

        var that = this;
        this.model.save('', '', {
            success: function(model, response, options) {                
                $(e.target).removeAttr('disabled').text('Save');
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
var GoalObjectiveModalEditView = GoalObjectiveEditView.extend({
    el: $('#edit-objective-modal'),
    class: 'row-fluid',
    template: $('#goal-objective-edit-modal-template').html(),
    show: function() {
        this.render();
        this.$el.modal('show');
        this.afterShow();
    },
    saveSuccess: function() {
        this.$el.find('.modal-footer .label-success').remove();
        if (this.model.isNew()) {
            this.$el.find('.modal-footer').prepend('<span class="label label-success">Objective added.</span>');
        } else {
            this.$el.find('.modal-footer').prepend('<span class="label label-success">Objective updated.</span>');
        }
    },
    saveError: function() {
        this.$el.find('.modal-footer .label-important').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-important">Please correct the errors.</span>');
    },
    render: function() {
    	var that = this;
        var vars = this.model.toJSON();
        editView = new GoalObjectiveEditView({model: this.model});
        editView.subordinates = this.subordinates;

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        vars['edit_form'] = _e.html();

        if (this.model.isNew()) {
            vars['header'] = 'Add Objective for ' + this.goal.get('title');
        } else {
            vars['header'] = 'Edit objective: "' + this.model.get('title') + '"';
        }

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(vars));       
    },
});
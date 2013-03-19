var sep = '####';
// --------------------------------------------------------------------
// 
var EventView = Backbone.View.extend({
    tagName: "tr",
    events: {
        "click .delete" : "delete"
    },
    className: "event-container",
    template: $("#event-list-item").html(),    
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    },
    delete: function() {
        var that = this;        
        $('#event-delete').live('show', function () {
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
var EventEditView = Backbone.View.extend({
    template: $('#event-edit-form-template').html(),
    viewTemplate: $('#event-view-template').html(),
    events: {
        "click .save-event": "saveEvent",
        "change input,select,textarea,radio": "change",       
        "click .delete" : "delete",
        "click .icon-remove" : "deleteInvolved"
    },
    queryAttributes: {exclude_ids: new Array()},
    render: function () {
        var tmpl = _.template(this.template);

        this.$el.html(tmpl(this.model.toJSON()));   

        return this;
    },    
    renderForm: function() {
        this.render();

        var that = this;

        // Reset every instance the form is rendered.
        this.queryAttributes['exclude_ids'] = new Array();
        this.queryAttributes['exclude_ids'].push(this.model.get('user_id'));
        
        involved = this.model.get('involved');

        if (involved.length > 0) {
            $('#involved-container').parents('.control-group').removeClass('hidden');
            $.each(involved, function(idx, i) {
                that.queryAttributes['exclude_ids'].push(i.user_id);
            });
        }

        this.$el.find('.datepicker').each(function(index, e) {            
            var alt = that.$el.find('input[name="' + $(e).attr('rel') + '"]');            
            $(e).datetimepicker({
                altField : alt,
                altFormat: "yy-mm-dd",
                altTimeFormat: "HH:mm:ss",
                altFieldTimeOnly: false,
                timeFormat: "h:mm TT",
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

        $('#search-employee').typeahead({
            source: function (query, process) {
                that.queryAttributes['searchVal'] = query;
                var list = [];

                $.ajax({
                    url: BASE_URL + 'api/users',
                    data: that.queryAttributes,
                    dataType: 'json',
                    success: function (response) {
                        var data = new Array();
                        typeAheadCollection = new TypeAheadCollection(response.data);
                        _.each(typeAheadCollection.models, function(model) {
                            data.push(model.get('user_id') + sep + model.get('full_name'));
                        });
                        return process(data);
                    }
                });
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
                    if (i.user_id == id) {
                        exists = true;
                    }
                });

                if (exists) return;

                new_involved = new Involved({                    
                    user_id: id
                });

                involved.push(new_involved);
                that.model.set('involved', involved);

                var label = $('<a class="label label-info" />')
                    .attr('ref', id)
                    .html('<i class="icon-remove icon-white"></i> ' + parts.join(sep));

                $('#involved-container').parents('.control-group').removeClass('hidden');
                that.$el.find('#involved-container').append(label).append('\n');

                label.find('.icon-remove').on('click', function() {
                    label.remove();
                    that.handleRemoveInvite(label.attr('ref'));
                });
                
                that.queryAttributes['exclude_ids'].push(id);
            },            
            minLength: 4
        });  

        this.$el.find('.colorpicker').colorpicker({format: 'hex'}).on('changeColor', function(event) {
            that.model.set('color', event.color.toHex()) 
        });

        autocomplete = new google.maps.places.Autocomplete(document.getElementById('location_search'));

        return this;
    },
    deleteInvolved: function(e) {
        this.handleRemoveInvite($(e.target).parent().attr('ref'));
        $(e.target).parent().remove();        
    },
    handleRemoveInvite: function(user_id) {
        involved = this.model.get('involved');
        index = -1;
        $.each(involved, function(idx, i) {
            if (i.user_id == user_id) {
                index = idx;
            }
        });

        if (index > -1) {
            _i = new Involved(involved[index]);
            _i.destroy();
            
            involved.splice(index, 1);

            this.model.set('involved', involved);
        }

        // Get index so that it can be removed from exclude_ids thus making the name
        // searchable again
        index = this.queryAttributes['exclude_ids'].indexOf(user_id);
        this.queryAttributes['exclude_ids'].splice(index, 1);

        if (this.queryAttributes['exclude_ids'].length == 1) {
            $('#involved-container').parents('.control-group').addClass('hidden');
        }
    },
    change: function(e) {
        this.model.set($(e.target).attr('name'), $(e.target).val());
    }, 
    saveEvent: function(e) {
        var that = this;

        e.preventDefault();
        $('.label-important').remove();
        $('.label-success').remove();
        $(e.target).attr('disabled', true).text('Sending...');

        // Convert the dates to mysql format so that it can be saved
        from = this.model.get('date_from');        
        if (typeof(from) == 'object') {
            this.model.set('date_from', from.getUTCFullYear() + '-' + (from.getMonth() + 1) + '-' + from.getDate() + ' ' + from.getHours() + ':' + from.getMinutes() + ':' + from.getSeconds());
        }

        to = this.model.get('date_to');
        if (typeof(to) == 'object') {        
            this.model.set('date_to', to.getUTCFullYear() + '-' + (to.getMonth() + 1) + '-' + to.getDate() + ' ' + to.getHours() + ':' + to.getMinutes() + ':' + to.getSeconds());
        }

        this.model.save('', '', {
            success: function(model, response, options) {
                $(e.target).removeAttr('disabled').text('Update Event');

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
    },
    delete: function() {

    },    
});

// --------------------------------------------------------------------
//
var EventModalEditView = EventEditView.extend({
    el: $('#event-edit-modal'),
    class: 'row-fluid',
    template: $('#event-edit-modal-template').html(),
    show: function() {        
        this.renderForm();

        this.$el.modal('show');   
    },
    saveSuccess: function() {
        this.$el.find('.modal-footer .label-success').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-success">Event successfully filed.</span>');        
    },
    saveError: function() {
        this.$el.find('.modal-footer .label-important').remove();
        this.$el.find('.modal-footer').prepend('<span class="label label-important">Please correct the errors.</span>');
    },    
    delete: function() {
        var that = this;        
        $('#event-delete').on('show', function () {
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
        editView = new EventEditView({model: this.model});

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        this.model.set('edit_form', _e.html());        

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
    },
});

// --------------------------------------------------------------------
//
var InvolvedView = Backbone.View.extend({    
    template: $('#event-view-template').html(),
    events: {
        "click .attend-event": "attend",
        "click .reject-event": "reject",
        "click .tentative-event": "tentative"
    },    
    render: function () {
        var tmpl = _.template(this.template);

        this.$el.html(tmpl(this.model.toJSON()));   

        return this;
    },
    attend: function(e) {
        this.model.set('status_id', Involved.prototype.accepted_status);
        this.save(e);
    },
    reject: function(e) {
        this.model.set('status_id', Involved.prototype.denied_status);
        this.save(e);
    },
    tentative: function(e) {
        this.model.set('status_id', Involved.prototype.tentative_status);
        this.save(e);
    },    
    save: function(e) {
        var that = this;
        $(e.target).attr('disabled', 'disabled');
        this.model.save('','', {
            success: function(model) {
                model.trigger('saveSuccess');
                that.saveSuccess();
                $(e.target).removeAttr('disabled');
            }
        });
    }
});

// --------------------------------------------------------------------
//

var InvolvedModalView = InvolvedView.extend({
    el: $('#event-edit-modal'),
    class: 'row-fluid',
    template: $('#event-edit-modal-template').html(),
    show: function() {        
        this.render();

        this.$el.modal('show');
        this.$el.on('hidden', function() {            
            calendarApp.router.navigate('/');
        });
    },
    saveSuccess: function() {
        this.render();
    },
    saveError: function() {
    },
    render: function() {
        this.$el.html('');
        editView = new InvolvedView({model: this.model});

        _e = editView.render().$el;

        _e.find('.action-buttons').remove();

        this.model.set('edit_form', _e.html());        

        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
    },
});
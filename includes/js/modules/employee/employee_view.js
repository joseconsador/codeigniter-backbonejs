// --------------------------------------------------------------------
// 
var EmployeeView = Backbone.View.extend({
    tagName: "tr",
    className: "employee-container",
    template: $("#emp-list-item").html(),    
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }
});

// --------------------------------------------------------------------
//
var EmployeeModalEditView = Backbone.View.extend({
	el: $('#employee-edit-modal'),
	initialize: function() {
        optionsCollection = new OptionsCollection();
        optionsCollection.on('reset', this.renderDropdownOptions, this);
        optionsCollection.fetch();
	},
    events: {
        "click .btn-primary": "saveEmployee",
        "change input,select": "change"
    },
    render: function() {        
        this.$el.modal('show');
        this.$el.find('#myTabContent').hide();
        this.$el.find('#tab-loading').show();

        var that = this;
        
        $.each(this.model.toJSON(), function(key, value) {
            that.$el.find('#' + key).val(value);            
        });

        $('.datepicker').each(function(index, e) {            
            var alt = "#" + $(e).attr('rel');
            $(e).datepicker({ 
                altField : alt,
                altFormat: "yy-mm-dd",
                onSelect: function(dateText, inst) {
                    $(alt).trigger('change');
                }
            });

            $(e).datepicker("setDate", new Date($(alt).val()));            
        });

        if (this.model.isNew()) {
            this.$el.find('.edit-modal-title').text('Add New Employee');
        } else {
            this.$el.find('.edit-modal-title').text(this.model.get('full_name'));
        }

        person = this.model.person();
        
        person.fetch({            
            success: function (model,response,options) { 
                that.$el.find('#tab-loading').hide();
                that.$el.find('#myTabContent').show();
                that.renderPersonTabs(model);
            }
        });        
    },
    change: function(e) {
        this.model.set($(e.target).attr('id'), $(e.target).val());
    },
    saveEmployee: function(e) {
        e.preventDefault();
        $(e.target).attr('disabled', true).text('Saving...');        
        this.model.save('', '', {success: 
            function(model, response, options) {                
                $(e.target).removeAttr('disabled').text('Save');
            }
        });
    },
    renderDropdownOptions: function(e) {
        
    },
    renderPersonTabs: function(model) {        
        this.renderReferences(model.get('references'));
        this.renderWorkHistory(model.get('work_experience'));
    },
    renderReferences: function(references) {
        var referenceCollection = new ReferenceCollection();
        var referencesView = new ReferencesModalEditView({collection: referenceCollection});
        referenceCollection.reset(references);
    },
    renderWorkHistory: function(workhistory) {        
        var workCollection = new WorkhistoryCollection();
        var workView = new WorkhistorysModalEditView({collection: workCollection});
        workCollection.reset(workhistory);
    }    
});
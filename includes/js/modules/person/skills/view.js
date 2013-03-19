// --------------------------------------------------------------------
//
// Skills
// 
// --------------------------------------------------------------------

// --------------------------------------------------------------------
//
var SkillEditItemView = Backbone.View.extend({
	tagName: 'div',
    className: 'well',
    skillTypes: null,
    proficiencyTypes: null,    
    template: $('#edit-skill-template').html(),
    events: {
        'change input,select,textarea': 'change',
        'change select[name="skill_type_id"]': 'setSkillType',
        'change select[name="proficiency_id"]': 'setProficiency',
    },
    setSkillType: function(e) {
        this.model.set('skill_type', $(e.target).find('option:selected').text());
    },
    setProficiency: function(e) {        
        this.model.set('proficiency', $(e.target).find('option:selected').text());
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

var SkillListView = Backbone.View.extend({    
    el: '#skill-table',
    initialize: function () {
        this.collection.on('add', this.renderOne, this);
    },
    render: function () {
        _.each(this.collection.models, this.renderOne, this);
    },
    renderOne: function (item) {
        item.set({actions: false});
        view = new SkillListItemView({model: item});
        this.$el.find('tbody').append(view.render().el);
    }
});

// --------------------------------------------------------------------
//

/** @type object Renders and handles the <tr> for the employee list view */
var SkillListItemView = Backbone.View.extend({    
    template: $('#skill-item-template').html(),
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
        $('#skill-delete').on('show', function () {
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

var SkillListItemSubView = Backbone.View.extend({
    tagName: 'tr',
    template: $('#skill-item-sub-template').html(), 
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
var SkillListEditView = Backbone.View.extend({    
    el: '#skills',
    initialize: function () {
        this.collection.on('add', this.render, this);

        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini addbtn" href="#"><i class="icon-plus"></i> Add</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn btn-cancel actions" href="#">Cancel</a>');
        this.$el.find('h3').append('&nbsp;<a class="btn btn-mini btn-primary actions" href="#">Save</a>');
        
        this.$el.find('.actions').hide();
        $('#skill-table thead tr').append('<th>Actions</th>');
    },
    render: function () {
        $('#skill-table tbody').empty();

        _.each(this.collection.models, this.renderOne, this);
    },
    skillTypes: null,
    proficiencyTypes: null,
    renderOne: function (item) {
        item.set({actions: true});
        view = new SkillListItemView({model: item});
        var subview = new SkillListItemSubView({model: item});
        $('#skill-table tbody').append(view.render().el).append(subview.render().el);
        
        view.on('edit', function() {
            this.showForm(item);            
        }, this);

        view.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Skill removed.</span>');
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
        this.showForm(new SkillModel({
            person_id: this.options.person_id,
            proficiencyTypes: this.proficiencyTypes,
            skillTypes: this.skillTypes
        }
        ));
    },  
    showForm: function(model) {
        var that = this;
        if (that.skillTypes == null) {     
            $.ajax({
                url: BASE_URL + 'api/admin_options/masters?option_group=SKILL-TYPE',
                success: function(response) {
                    that.skillTypes = response.data;                    

                    if (that.proficiencyTypes == null) {            
                        $.ajax({
                            url: BASE_URL + 'api/admin_options/masters?option_group=PROFICIENCY',
                            success: function(response) {
                                that.proficiencyTypes = response.data;                                
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
        
        model.set('proficiencyTypes', this.proficiencyTypes);
        model.set('skillTypes', this.skillTypes);

        this.editView = new SkillEditItemView({model: model});

        this.$el.find('.form-container').html(this.editView.render().el);   
    },
    editView: null
});

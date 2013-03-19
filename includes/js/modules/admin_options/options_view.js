// --------------------------------------------------------------------
// 
var OptionsView = Backbone.View.extend({
    tagName: "tr",
    className: "employee-container",
    template: $("#emp-list-item").html(),
    editTemplate: _.template($("#option-edit-template").html()),
    events: {
    	"click .record-delete" : "confirmDelete",
        "click .record-edit"   : "editPost"
    },
    editPost: function (e) {        
        e.preventDefault();

        this.$el = $('#container-option-edit');
        var that = this;        
        this.$el.empty();
        this.$el.html(this.editTemplate(this.model.toJSON()));

        $('#editData').live('show', function () {
            $(this).find('.btn-primary').die().live('click', function () {  

                var d = Array;
                $.map($('.inopt input').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });                
               
                that.model.save(d, {
                    success: function (model, response) {
                        this.$el = $('#editData');
                        this.$el.modal('hide');
                    },
                    error: function (model, response) {
                        alert("error");
                    },
                });

            });               
        })
        .modal();
    },
    confirmDelete: function (e) {
    	e.preventDefault();
    	var that = this;
    	$('#deleteData').live('show', function () {
            $(this).find('.btn-danger').die().live('click', function () {                
                that.model.destroy({success: function (model, response) {
                    // Remove this view from the DOM                
                    that.remove();
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

var OptionsForm = Backbone.View.extend({
    template: $('#container-option-add'),
    addTemplate: _.template($("#option-add-template").html()),
    render: function () { 
        this.template.empty();
        this.template.html(this.addTemplate(this.model.toJSON()));
        return this;
    }
});

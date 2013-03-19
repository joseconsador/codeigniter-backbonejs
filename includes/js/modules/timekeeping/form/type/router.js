// --------------------------------------------------------------------
// 
var FormtypeListRouter = Backbone.Router.extend({
    routes: {
        '' : 'defaultList' ,
        'add' : 'add'       
    },
    listLoaded: false,
    defaultList: function () {
        this.listLoaded = true;
    },
    add: function() {
        $('#add-formtype').trigger('click');
        
        if (!this.listLoaded) {
            this.defaultList();
        }        
    }
});
// --------------------------------------------------------------------
// 
var FormtypeEditRouter = Backbone.Router.extend({
    routes: {
        'edit' : 'edit'
    },
    edit: function () {
        $('#company-information, #employment-information').find('a.edit').trigger('click');        
    }
});
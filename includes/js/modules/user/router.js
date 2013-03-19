// --------------------------------------------------------------------
// 
var UserListRouter = Backbone.Router.extend({
    routes: {
        '' : 'defaultList' ,
        'add' : 'add'       
    },
    listLoaded: false,
    defaultList: function () {
        this.listLoaded = true;
    },
    add: function() {
        $('#add-user').trigger('click');
        
        if (!this.listLoaded) {
            this.defaultList();
        }        
    }
});
// --------------------------------------------------------------------
// 
var UserEditRouter = Backbone.Router.extend({
    routes: {
        'edit' : 'edit'
    },
    edit: function () {
        $('#company-information, #employment-information').find('a.edit').trigger('click');        
    }
});
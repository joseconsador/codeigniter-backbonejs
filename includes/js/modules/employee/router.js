// --------------------------------------------------------------------
// 
var EmployeeListRouter = Backbone.Router.extend({
    routes: {
        '' : 'defaultList',
        'status/:id' : 'loadList',
        'status/' : 'loadList',
        'add' : 'add'
    },
    listLoaded: false,
    defaultList: function () {
        id = $('a[data-toggle="tab"]:first').attr('dep');
        $('li a[dep="' + id + '"]').trigger('shown');
        this.listLoaded = true;
    },
    loadList: function (id) {
        $('li a[dep="' + id + '"]').tab('show');
        this.listLoaded = true;
    },
    add: function() {
        $('#add-employee').trigger('click');
        // Load default list if direct referral
        if (!this.listLoaded) {
            this.defaultList();
        }
    }
});

// --------------------------------------------------------------------
// 
var EmployeeEditRouter = Backbone.Router.extend({
    routes: {
        'edit' : 'edit'
    },
    edit: function () {
        $('#company-information, #employment-information').find('a.edit').trigger('click');        
    }
});
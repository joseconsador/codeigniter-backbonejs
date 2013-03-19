// --------------------------------------------------------------------
// 
var EmployeeListRouter = Backbone.Router.extend({
    routes: {
        '' : 'defaultList',
        'status/:id' : 'loadList',
        'status/' : 'loadList',
    },
    initialize: function () {
    
    },
    defaultList: function () {
        id = $('a[data-toggle="tab"]:first').attr('dep');

        $('li a[dep="' + id + '"]').trigger('shown');
    },
    loadList: function (id = '') {        
        $('li a[dep="' + id + '"]').tab('show');
    }    
});
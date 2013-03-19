var FormListRouter = Backbone.Router.extend({
    routes: {
        '' : 'default',
        'form/:id' : 'showForm'
    },    
    default: function() {

    },
}); 

$(function() {
    var formListRouter = new FormListRouter();
    formListRouter.on('route:showForm', directoryView.modalEdit.showForm, directoryView.modalEdit);
});
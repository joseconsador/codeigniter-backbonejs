var MessageRouter = Backbone.Router.extend({
    routes: {
        '' : 'getInbox',
        'inbox' : 'getInbox',
        'sent'  : 'getSent',
        'inbox/:id' : 'getMessage'
    },
    getInbox: function () {        
    	$('a[href="#inbox"]').tab('show').trigger('shown');
    },
    getSent: function () {
    	$('a[href="#sent"]').tab('show');	    	
    }
});	

$(function(){
    var messagesView = new MessagesView();
    var messageRouter = new MessageRouter();
    messageRouter.on('route:getMessage', function(id) {
        messagesView.getMessage(id);

        app.modalMessage.$el.on('hidden', function() {
            messageRouter.navigate('/');                   
        });
    });
});
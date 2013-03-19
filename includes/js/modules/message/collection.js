/**
 * A collection of one user's messages
 * @type {[type]}
 */
var MessageCollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + 'api/messages?offset=' + this.page + '&limit=' + this.limit;
    },
    page: 0,
    limit: 10,
    model: MessageModel,
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;
        //Normally this.totalPages would equal response.d.__count
        //but as this particular NetFlix request only returns a
        //total count of items for the search, we divide.        
        this.totalPages = Math.ceil(response._count / this.perPage);
        this.totalRecords = response._count;
        return tags;
    }    
});

// --------------------------------------------------------------------
// 
 
var RecievedMessagesCollection = Backbone.Paginator.requestPager.extend({    
    model: MessageModel,
    paginator_core: {        
        type: 'GET',
        dataType: 'json',
        url: BASE_URL + 'api/messages/recieved'
    },
    
    paginator_ui: {        
        firstPage: 1,
        currentPage: 1,
        perPage: 5,        
        totalPages: 10
    },
    server_api: {
        'limit': function() { return this.perPage;},
        'offset': function() { 
            if (this.currentPage == 0) {
                this.currentPage = 1;
            }

            return (this.currentPage - 1) * this.perPage;
        }        
    },    
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;
        //Normally this.totalPages would equal response.d.__count
        //but as this particular NetFlix request only returns a
        //total count of items for the search, we divide.        
        this.totalPages = Math.ceil(response._count / this.perPage);
        this.totalRecords = response._count;
        return tags;
    }    
});

// --------------------------------------------------------------------
// 

var SentMessagesCollection = Backbone.Paginator.requestPager.extend({    
    model: MessageModel,
    paginator_core: {        
        type: 'GET',
        dataType: 'json',
        url: BASE_URL + 'api/messages/sent'
    },
    
    paginator_ui: {        
        firstPage: 1,
        currentPage: 1,
        perPage: 10,        
        totalPages: 10
    },
    server_api: {
        'limit': function() { return this.perPage;},
        'offset': function() { 
            if (this.currentPage == 0) {
                this.currentPage = 1;
            }

            return (this.currentPage - 1) * this.perPage;
        }        
    },    
    parse: function (response) {        
        // Be sure to change this based on how your results        
        var tags = response.data;
        //Normally this.totalPages would equal response.d.__count
        //but as this particular NetFlix request only returns a
        //total count of items for the search, we divide.        
        this.totalPages = Math.ceil(response._count / this.perPage);
        this.totalRecords = response._count;
        return tags;
    }    
});
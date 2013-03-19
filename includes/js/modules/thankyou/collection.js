/**
 * A collection of thank you
 * @type {[type]}
 */
var ThankyouCollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + 'api/thankyous';
    },
    page: 0,
    limit: 10,
    model: ThankyouModel,
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

/**
 * A collection of a user's recieved thank you
 * @type {[type]}
 */
var RecievedThankyouCollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + 'api/user/id/' + this.user_id + '/thankyous/recieved';
    },
    user_id: 0,    
    model: ThankyouModel,
    parse: function (response) {
        var ids = [];        
        var data = [];
        // Remove duplicate users, get latest
        $.each(response.data, function(index, model) {
            if ($.inArray(model.user_id, ids) == -1) {
                ids.push(model.user_id);
                data.push(model);
            }
        });
        
        return data;
    }    
});
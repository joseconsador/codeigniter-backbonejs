/**
 * A collection of timelogs
 * @type {[type]}
 */
var TimelogCollection = Backbone.Collection.extend({
    url: function () {
        return BASE_URL + 'api/timelogs';
    },
    page: 0,
    limit: 10,
    model: TimelogModel,
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
 * A collection of an employees timelogs
 * @type {[type]}
 */
var EmployeeTimelogCollection = Backbone.Paginator.requestPager.extend({    
    employee_id: 0,
    paginator_core: {        
        type: 'GET',
        dataType: 'json',
        url: function() { return BASE_URL + 'api/employee/id/' + this.employee_id + '/timelogs'; }
    },
    
    paginator_ui: {        
        from: null,        
        to: null
    },
    server_api: {
        'from' : function() { return this.from; },
        'to': function() {return this.to; }
    },      
    model: TimelogModel,
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
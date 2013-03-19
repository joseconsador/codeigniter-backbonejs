var Feed = Backbone.Model.extend({
    url: function () {
        if (this.isNew()) {
            return BASE_URL + 'api/feed'; 
        } else {
            return BASE_URL + 'api/feed/id/' + this.get('id'); 
        }
    },  
    defaults: {
        restrict: 0
    }
});

var Stream = Backbone.Collection.extend({    
    url: function () {
        return BASE_URL + 'api/user/id/' + this.user + '/feeds?offset=' + this.page + '&limit=' + this.limit;
    },
    page: 0,
    user: 0,
    limit: 10,
    model: Feed
}); 

var FeedView = Backbone.View.extend({
    tagName: "div",
    className: "well posted-status",
    template: $("#feedTemplate").html(),
    events: {
        "click .feed-delete" : "confirmDelete",
        "click .feed-edit"   : "editPost"
    },
    editPost: function (e) {
        
    },
    confirmDelete: function (e) {
        e.preventDefault();
        var that = this;
        $('#modal-delete').on('show', function () {
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

// Master view
var StreamView = Backbone.View.extend({
    el: $("#stream-container"),
    initialize: function () {        
        this.collection = this.options.collection;
        this.isLoading = false;
        this.render();
        this.collection.on("add", this.renderFeed, this);        
    },
    events: {
        'click #loadmore-feed' : 'loadMore'
    },
    render: function () {
        var that = this;
        this.isLoading = true;
        this.collection.fetch({success: function () {
                _.each(that.collection.models, function (item) {
                    that.renderFeed(item);
                }, this);
                that.isLoading = false;
                $("abbr.timeago").timeago();
                
                that.$el.find('#load-more-container').html(
                    _.template($('#load-more-template').html())
                );                
            }
        });
    },
    renderFeed: function (item) {        
        var feedView = new FeedView({
            model: item
        });
        
        this.$el.find('#feed-container').append($(feedView.render().el).hide().fadeIn('slow'));
    },    
    loadMore: function () {
        this.collection.page += 10;
        this.render();        
    }
});

var StatusForm = Backbone.View.extend({
    el: $('#add-status-form'),
    initialize: function () {
        var e = [];
        e.target = '#feeds';
        this.enableAdd(e);
    },
    //add ui events
    events: {            
        "click #add": "addStatus",
        "keyup #feeds": "enableAdd"
    },
    enableAdd: function (e) {        
        if ($(e.target).val().length > 0) {
            this.$el.find('#add').removeClass('disabled');
            this.$el.find('#add').addClass('btn-primary');
        } else {
            this.$el.find('#add').removeClass('btn-primary');
            this.$el.find('#add').addClass('disabled');
        }
    },
    addStatus: function (e) {            
        e.preventDefault();

        if ($(e.target).hasClass('disabled')) {
            return false;
        }

        var that = this;
        var formData = {created: new Date().toString('yyyy-MM-dd H:m:ss')};

        $(e.target).text('Sharing...').attr('disabled', true);

        $.each($("#add-status-form").serializeArray(), function(index, e) {
            formData[e.name] = e.value;
        });

        feed = new Feed();
        feed.save(formData, {
            success: function (model, response) {                        
                if (response.status == '200') {
                    feed.id = response.id;

                    var feedView = new FeedView({
                        model: feed
                    });                        

                    that.options.stream.$el.prepend($(feedView.render().el).hide().slideDown('slow'));
                    $("abbr.timeago").timeago();                        
                }

                $(e.target).text('Share');
                $(e.target).text('Share').attr('disabled', false);
            },
            error: function (model, response) {
                $(e.target).text('Share').attr('disabled', false);
            }
        });
    },
});

// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    modalEdit: null,    
    el: $("#user-list-view"),    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;        

        this.collection.on('add', this.renderUser, this);        
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);        

        // This is to make sure only one instance of the view is called on addUser
        this.modalEdit = new UserModalEditView();
    },
    events: {        
        "click #user-list-view .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-user": "loadMore",
        "click #add-user" : "addUser",        
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    addUser: function(e) {
        this.modalEdit.model = new User();
        this.modalEdit.show();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#user-table tbody').empty();
        this.collection.currentPage = 1;        
        this.collection.searchVal = $('#search').val();
        this.collection.pager();
    },
    updateSortBy: function (e) {                        
        if (this.collection.sortDir == 'desc') {
            dir = 'asc';
        } else {
            dir = 'desc';
        }
        this.collection.sortDir = dir;        
        this.collection.updateOrder($(e.target).attr('col'));
    },    
    render: function () {
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#user-table tbody').empty();
        }

        this.collection.each(this.renderUser, this);                    

        $('#search').typeahead({
            source: function (query, process) {
                queryAttributes = {};
                queryAttributes['searchVal'] = query;
                var list = [];

                $.ajax({
                    url: that.collection.paginator_core.url,
                    data: queryAttributes,
                    dataType: 'json',
                    success: function (response) {
                        typeAheadCollection = new TypeAheadCollection(response.data);
                        return process(typeAheadCollection.pluck('full_name'));
                    }
                });                
            },            
            minLength: 4
        });        
    },
    renderUser: function (item) {
        var userView = new UserView({
            model: item
        });        

        $('#user-table tbody').append(userView.render().el);        

        var that = this;
        userView.$el.find('.edit').on('click', 
            function() {
                that.modalEdit.model = item;
                that.modalEdit.show();

                // Updates the list with the new values after saving.
                that.modalEdit.model.on('sync', function() {                    
                    that.collection.pager();
                });
            }
        );

        userView.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">User deleted.</span>');
            userView.remove();
            this.collection.pager();
        }, this);        
    },
});
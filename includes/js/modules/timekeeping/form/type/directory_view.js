// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    modalEdit: null,    
    el: $("#formtype-list-view"),    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;        

        this.collection.on('add', this.renderFormtype, this);        
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);        

        // This is to make sure only one instance of the view is called on addFormtype
        this.modalEdit = new FormtypeModalEditView();
    },
    events: {        
        "click #formtype-list-view .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-formtype": "loadMore",
        "click #add-formtype" : "addFormtype",        
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    addFormtype: function(e) {
        this.modalEdit.model = new FormType();
        this.modalEdit.show();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#formtype-table tbody').empty();
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
            $('#formtype-table tbody').empty();
        }

        this.collection.each(this.renderFormtype, this);                    

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
    renderFormtype: function (item) {
        var formtypeView = new FormtypeView({
            model: item
        });        

        $('#formtype-table tbody').append(formtypeView.render().el);        

        var that = this;
        formtypeView.$el.find('.edit').on('click', 
            function() {
                that.modalEdit.model = item;
                that.modalEdit.show();

                // Updates the list with the new values after saving.
                that.modalEdit.model.on('sync', function() {                    
                    that.collection.pager();
                });
            }
        );

        formtypeView.on('delete', function () {
            this.$el.find('.form-container').html('<span class="label label-success">Form Type deleted.</span>');
            formtypeView.remove();
        }, this);        
    },
});
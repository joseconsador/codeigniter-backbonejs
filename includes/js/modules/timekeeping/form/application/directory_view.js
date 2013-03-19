// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    modalEdit: null,    
    el: $("#form-list-view"),    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        this.collection.isLoading = false;        

        this.collection.on('add', this.renderForm, this);        
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);        

        // This is to make sure only one instance of the view is called on addForm
        this.modalEdit = new FormModalEditView();
    },
    events: {        
        "click #form-list-view .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-form": "loadMore",
        "click #add-form" : "addForm",        
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    addForm: function(e) {
        this.modalEdit.model = new Form();
        this.modalEdit.show();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#form-table tbody').empty();
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
    // Renders the table
    render: function () {
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#form-table tbody').empty();
        }

        this.collection.each(this.renderForm, this);                    

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
    // Renders the table row
    renderForm: function (item) {
        var formView = new FormView({
            model: item
        });        

        $('#form-table tbody').append(formView.render().el);        

        var that = this;
        formView.$el.find('.edit').on('click', 
            function() {
                that.modalEdit.model = item;
                that.modalEdit.show();

                // Updates the list with the new values after saving.
                that.modalEdit.model.on('sync', function() {
                    that.collection.pager();
                });
            }
        );

        item.on('sync', function() {
            that.collection.pager();
        });

        formView.on('delete', function () {
            formView.remove();
        }, this);
    },
});
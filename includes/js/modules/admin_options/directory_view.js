// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    el: $("#options-list-view"),  
    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            this.options.status_id = $('a[data-toggle="tab"]:first').attr('dep');
        }       
        
        this.collection.isLoading = false;
        
        this.collection.status_id = this.options.status_id;
        this.collection.on('add', this.renderOptions, this);  
        this.collection.on('add', this.renderOptionsform, this);
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);
    },
    events: {
        "shown a[data-toggle='tab']": "showStatus",
        "click .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-options": "loadMore",
        "click .record-add"   : "addPost"
    }, 
    addPost: function (e) {
        e.preventDefault();

        var that = this;        

        $('#addData').live('show', function () {
            $(this).find('.btn-success').die().live('click', function () {  

                var d = Array;
                $.map($('.inopts input').serializeArray(), function(n, i) {
                    d[n['name']] = n['value'];
                });  

                options = new Options();             
               
                options.save(d, {
                    success: function (model, response) {
                        this.$el = $('#addData');
                        this.$el.modal('hide');
                        // alert = new AlertView({type: 'success', message: 'Update success.'});
                        // alert.render();
                        //$('#cancel-btn').trigger('click');
                    },
                    error: function (model, response) {
                        alert("error");
                        // alert = new AlertView({type: 'error', message: response});
                        // alert.render();
                    },
                });

            });               
        })
        .modal();
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#options-table-' + this.collection.status_id + ' tbody').empty();
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
    showStatus: function (e) {
        window.location.hash = '/status/' + $(e.target).attr('dep');
        var options = this.collection;
        options.status_id = $(e.target).attr('dep');
        options.currentPage = 0;
        options.pager();
    },
    render: function () {        
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#options-table-' + this.collection.status_id + ' tbody').empty();
        }
     
        this.collection.each(this.renderOptions, this);  
        this.collection.each(this.renderOptionsform, this);                    

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
                        return process(typeAheadCollection.pluck('option'));
                    }
                });                
            },            
            minLength: 4
        });  

        $('[rel="clickover"]').clickover({
            placement: get_popover_placement,
            html: true
        });
    },
    renderOptions: function (item) {
        var optionsView = new OptionsView({
            model: item
        });

        $('#options-table-' + this.collection.status_id + ' tbody').append(optionsView.render().el);
    },    
    renderOptionsform: function (item) {
        var optionsForm = new OptionsForm({
            model: item
        });

        $('#container-option-add').append(optionsForm.render().el);
    }
});
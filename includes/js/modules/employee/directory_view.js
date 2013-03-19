// --------------------------------------------------------------------
// 
var DirectoryView = Backbone.View.extend({
    modalEdit: null,    
    el: $("#employee-list-view"),    
    initialize: function () {        
        $('.sortcolumn').css('cursor', 'pointer');

        if (this.options.status_id == undefined) {
            this.options.status_id = $('a[data-toggle="tab"]:first').attr('dep');
        }

        this.collection.isLoading = false;

        this.collection.status_id = this.options.status_id;

        this.collection.on('add', this.renderEmployee, this);        
        this.collection.on('reset', this.render, this);        

        this.collection.on("fetch", function() {
            this.collection.isLoading = true;
            $('#loader-container').html('<img src="'+ BASE_URL + 'includes/img/ajax-loader.gif" />');
        }, this);        

        // This is to make sure only one instance of the view is called on addEmployee
        this.modalEdit = new AddEmployeeView();
    },
    events: {
        "shown #201listTab a[data-toggle='tab']": "showStatus",
        "click #employee-list-view .sortcolumn": "updateSortBy",
        "click #submit-search": "toggleSearch",
        "click #loadmore-employee": "loadMore",
        "click #add-employee" : "addEmployee"
    },
    loadMore: function (e) {    
        this.collection.requestNextPage();        
    },
    addEmployee: function(e) {        
        this.modalEdit.show();        
    },
    toggleSearch: function (e) {
        // Clear contents every search because on mobile the content gets appended.
        $('#employee-table-' + this.collection.status_id + ' tbody').empty();
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
        var employees = this.collection;
        employees.status_id = $(e.target).attr('dep');
        employees.currentPage = 0;
        employees.pager();
    },
    render: function () {        
        var that = this;
        $('#loader-container').empty();
        
        this.collection.isLoading = false;

        // Change pager behavior depending on device
        if ($('#load-more-container').is(':hidden')) {
            $('#employee-table-' + this.collection.status_id + ' tbody').empty();
        }

        this.collection.each(this.renderEmployee, this);                    

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

        $('[rel="clickover"]').clickover({
            placement: get_popover_placement,
            html: true
        });
    },
    renderEmployee: function (item) {
        var employeeView = new EmployeeView({
            model: item
        });
        
        $('#employee-table-' + this.collection.status_id + ' tbody').append(employeeView.render().el);

        var that = this;
        
        /*employeeView.$el.find('.edit').on('click', 
            function() {
                that.modalEdit.model = item;
                that.modalEdit.render();
            }); */
    },
});
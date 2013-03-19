<div class="container-fluid" id="form-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Immediate <small>&raquo; Timekeeping &raquo; Time-off Applications</small></h2>
            </div>
            <div class="row-fluid">
                <div class="pull-right" id="pagination"></div>
                <form class="form-search" autocomplete="off">
                    <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                    <button type="submit" class="btn" id="submit-search">Search</button>
                    <span id="loader-container"></span>
                </form>

                <div class="tab-pane fade in">
                    <table class="responsive-table" id="form-table">
                        <thead>
                          <tr>
                            <th class="sortcolumn" col="form_code">Employee</th>
                            <th class="sortcolumn" col="form">Form Type</th>
                            <th class="sortcolumn" col="date_from">Date From</th>
                            <th class="sortcolumn" col="date_to">Date To</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="load-more-container" class="visible-phone">
                        <p>
                            <div class="progress progress-striped active">
                                <div class="bar" style="width:100%;background-color:#eee"></div>
                            </div>
                            <div style="text-align:center">
                                <a href="javascript:void(0);" id="loadmore-form">Load more</a>
                            </div>  
                        </p>
                    </div>
                </div>
            </div>            
        </div><!--/span-->        
    </div><!--/row-->
</div>
<!-- backbonejs view template -->
<?php $this->load->view('template/form_application_row');?>
<?php $this->load->view('template/pagination');?>

<script type="text/javascript">
    $(document).ready(function() {
        var paginatedItems = new PaginatedCollection();
        paginatedItems.paginator_core.url = BASE_URL + 'api/forms/for_approval?';
        window.directoryView = new DirectoryView({collection: paginatedItems});
        var pagination = new PaginatedView({collection: paginatedItems});
        /*Script for autoloading on mobile device*/
        $(window).scroll(function() {
             if (!directoryView.collection.isLoading && $('#load-more-container').is(':visible')
                && $(window).scrollTop() + $(window).height() > getDocHeight() - 100 ) {
                $('#loadmore-form').trigger('click');
            }
        });

        paginatedItems.pager();
    });
</script>
<div id="form-edit-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
<?php echo $this->load->view('template/form_application_template');?>

<div id="form-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Application</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this Application.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>
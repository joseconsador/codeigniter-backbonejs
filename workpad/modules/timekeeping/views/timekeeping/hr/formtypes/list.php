<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Form Code:"; }
  td:nth-of-type(2):before { content: "Form:"; }
  td:nth-of-type(3):before { content: "Description:"; }  
  td:nth-of-type(4):before { content: "Default Annual Amount:"; }  
  td:nth-of-type(5):before { content: "Default Annual Accumulation:"; }  
  td:nth-of-type(6):before { content: "Actions:"; }  
}

</style>

<div class="container-fluid" id="formtype-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>HR <small>&raquo; Timekeeping &raquo; Forms Setup</small></h2>
            </div>
            <div class="row-fluid">                
                <div class="pull-right" id="pagination"></div>
                <form class="form-search" autocomplete="off">
                    <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                    <button type="submit" class="btn" id="submit-search">Search</button>                        
                    <span id="loader-container"></span>
                </form>
                <a class="btn" href="#/add" id="add-formtype"><i class="icon-plus"></i> New Form Type</a>

                <div class="tab-pane fade in">
                    <table class="responsive-table" id="formtype-table">
                        <thead>
                          <tr>
                            <th class="sortcolumn" col="form_code">Code</th>
                            <th class="sortcolumn" col="form">Form Type</th>                                
                            <th class="sortcolumn" col="description">Description</th>
                            <th>Default Annual Amount</th>
                            <th>Default Accumulation</th>
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
                                <a href="javascript:void(0);" id="loadmore-formtype">Load more</a>
                            </div>  
                        </p>
                    </div>
                </div>
            </div>            
        </div><!--/span-->        
    </div><!--/row-->

<!-- backbonejs view template -->
<?php $this->load->view('template/formtypes_row');?>
<?php $this->load->view('template/pagination');?>

<script type="text/javascript">
    $(document).ready(function() {
        var paginatedItems = new PaginatedCollection();
        var directoryView = new DirectoryView({collection: paginatedItems});        
        var pagination = new PaginatedView({collection: paginatedItems});
        /*Script for autoloading on mobile device*/
        $(window).scroll(function() {
             if (!directoryView.collection.isLoading && $('#load-more-container').is(':visible')
                && $(window).scrollTop() + $(window).height() > getDocHeight() - 100 ) {
                $('#loadmore-formtype').trigger('click');
            }
        });

        window.formtypeListRouter = new FormtypeListRouter();
        paginatedItems.pager();
    });
</script>
<div id="formtype-edit-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
<?php echo $this->load->view('template/formtype_edit');?>

<div id="formtype-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Form Type</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this form type.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>                              
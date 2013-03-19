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

<div class="container-fluid" id="user-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Master <small>&raquo; Manage Users</small></h2>
            </div>
            <div class="row-fluid">                
                <div class="pull-right" id="pagination"></div>
                <form class="form-search" autocomplete="off">
                    <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                    <button type="submit" class="btn" id="submit-search">Search</button>                        
                    <span id="loader-container"></span>
                </form>
                <a class="btn" href="#/add" id="add-user"><i class="icon-plus"></i> New User</a>

                <div class="tab-pane fade in">
                    <table class="responsive-table" id="user-table">
                        <thead>
                          <tr>
                            <th class="sortcolumn" col="full_name">Name</th>
                            <th class="sortcolumn" col="login">Username</th>                                
                            <th class="sortcolumn" col="email">Email</th>
                            <th class="sortcolumn" col="last_login">Last Login</th>
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
                                <a href="javascript:void(0);" id="loadmore-user">Load more</a>
                            </div>  
                        </p>
                    </div>
                </div>
            </div>            
        </div><!--/span-->        
    </div><!--/row-->

<!-- backbonejs view template -->
<?php $this->load->view('user/template/users_row');?>
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
                $('#loadmore-user').trigger('click');
            }
        });

        window.userListRouter = new UserListRouter();
        paginatedItems.pager();
    });
</script>
<div id="user-edit-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
<?php echo $this->load->view('user/template/user_edit');?>

<div id="user-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete user</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this user.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>                              
<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Code:"; }
  td:nth-of-type(3):before { content: "Inactive:"; }
  td:nth-of-type(4):before { content: "Sort:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Master <small>&raquo; Employee File</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <?php foreach ($employment_statuses as $index => $employment_status):?>
                    <?php if ($index < 3):?>
                        <li>
                            <a href="#status_id-<?php echo strtolower($employment_status->option_group)?>" 
                                data-toggle="tab" dep="<?php echo strtolower($employment_status->option_group)?>"
                                rel="tooltip" title="<?php echo strtolower($employment_status->option_group); ?>">
                                <?php echo (strlen($employment_status->option_group) > 20) ? substr($employment_status->option_group,0,20) . '&hellip;' : ucwords(strtolower($employment_status->option_group));?>
                            </a>
                        </li>
                    <?php ;else:?>
                        <li <?php if ($index == 3): ?> class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                More
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                            <?php ;else:?>
                            ><!-- end <li> -->
                            <?php endif;?>
                            <a href="#status_id-<?php echo strtolower($employment_status->option_group)?>" 
                                data-toggle="tab" dep="<?php echo strtolower($employment_status->option_group)?>"
                                rel="tooltip" title="<?php echo strtolower($employment_status->option_group);?>"
                                >
                                <?php echo ucwords(strtolower($employment_status->option_group));?>
                            </a>
                        </li>
                        <?php if ($index == (count($employment_statuses) - 1)):?></ul><?php endif;?>
                    <?php endif;?>
                  <?php endforeach;?>
                </ul>               
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-container"></span>
                    </form>                     
                    <?php foreach ($employment_statuses as $employment_status):?>
                    <div class="tab-pane fade in" id="status_id-<?php echo strtolower($employment_status->option_group);?>">
                        <table class="responsive-table" id="options-table-<?php echo strtolower($employment_status->option_group);?>">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="name">Name</th>
                                <th class="sortcolumn" col="code">Code</th>                                
                                <th class="sortcolumn" col="inactive">Inactive</th>
                                <th>Sort</th>
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
                                    <a href="javascript:void(0);" id="loadmore-options">Load more</a>
                                </div>  
                            </p>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->

    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">          
        <td>
          <a data-content="
            <div class='row page-border'> </div>
            " 
            href="javascript:void(0);"
            rel="clickover" data-original-title="<%= option %>">
            <%= option %>
          </a>
        </td>
        <td><%= (option_code)? option_code : '' %>&nbsp;</td>        
        <td><%= (inactive == 1)? 'Yes' : 'No' %>&nbsp;</td>
        <td><%= sort_order %>&nbsp;</td>
        <td>
            <div class="btn-group">
                <a class="btn" rel="tooltip" title="Edit" 
                    href="#editData" data-toggle="modal">
                    <i class="icon-edit"></i>
                </a>
                <a class="btn" rel="tooltip" title="Remove" 
                    href="<?php echo site_url();?>">
                    <i class="icon-remove"></i>
                </a>                
            </div>
        </td>
    </script>

    <!-- Modal Contacts -->          
    <div class="modal hide fade" id="editData">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Master <small>&raquo; Employee File</small></h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div id="container-mobile"></div>
                <div id="container-other"></div>
                <div id="container-im"></div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn btn-primary" id="contacts-submit">Submit Changes</a>
        </div>
    </div>
    <!-- End contact -->

    <!-- backbonejs view template -->
    
    <?php $this->load->view('template/pagination');?>
<!-- Script for autoloading on mobile device -->
<script type="text/javascript">
    $(document).ready(function() {
        var paginatedItems = new PaginatedCollection();
        var directoryView = new DirectoryView({collection: paginatedItems});
        var pagination = new PaginatedView({collection: paginatedItems});

        $(window).scroll(function() {
             if (!directoryView.collection.isLoading && $('#load-more-container').is(':visible')
                && $(window).scrollTop() + $(window).height() > getDocHeight() - 100 ) {
                $('#loadmore-employee').trigger('click');
            }
        });

        var app_router = new EmployeeListRouter;

        Backbone.history.start();
    });
</script>
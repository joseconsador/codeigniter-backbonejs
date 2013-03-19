<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Position:"; }
  td:nth-of-type(3):before { content: "Department:"; }
  td:nth-of-type(4):before { content: "Phone:"; }
  td:nth-of-type(5):before { content: "Email:"; }
}

</style>

<div class="container-fluid" id="employee-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>HR <small>&raquo; List of employee</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="201listTab" class="nav nav-tabs">
                  <?php 
                    $_status = $employment_statuses->data;
                    $all = new stdClass();
                    $all->option = 'All';
                    $all->option_id = '';

                    $_status[] = $all;                    
                  foreach ($_status as $index => $employment_status):?>
                    <?php if ($index < 3):?>
                        <li>
                            <a href="#status_id-<?php echo $employment_status->option_id?>" 
                                data-toggle="tab" dep="<?php echo $employment_status->option_id?>"
                                rel="tooltip" title="<?php echo $employment_status->option;?>">
                                <?php echo (strlen($employment_status->option) > 20) ? substr($employment_status->option,0,20) . '&hellip;' : $employment_status->option;?>
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
                            <a href="#status_id-<?php echo $employment_status->option_id?>" 
                                data-toggle="tab" dep="<?php echo $employment_status->option_id?>"
                                rel="tooltip" title="<?php echo $employment_status->option;?>"
                                >
                                <?php echo $employment_status->option;?>
                            </a>
                        </li>
                        <?php if ($index == (count($_status) - 1)):?></ul><?php endif;?>
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
                    <a class="btn" href="#/add" id="add-employee"><i class="icon-plus"></i> New Employee</a>
                    <?php foreach ($_status as $employment_status):?>
                    <div class="tab-pane fade in" id="status_id-<?php echo $employment_status->option_id;?>">
                        <table class="responsive-table" id="employee-table-<?php echo $employment_status->option_id;?>">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="first_name">Name</th>
                                <th class="sortcolumn" col="position">Position</th>                                
                                <th class="sortcolumn" col="department">Department</th>
                                <th>Phone</th>
                                <th class="sortcolumn" col="email">Email</th>
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
                                    <a href="javascript:void(0);" id="loadmore-employee">Load more</a>
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
            <center>
                <image src='<%= thumbnail_url %>' />
            </center>
            <div class='row page-border'> </div>
            <center>            
                <a class='btn' rel='tooltip' title='View Profile' 
                    href='<?php echo site_url();?>profile/<%= hash %>'>
                    View Profile
                </a>
                <a class='btn' rel='tooltip' title='View 201' 
                    href='<?php echo site_url();?>hr/employee/<%= hash %>'>
                    View 201
                </a> 
            </center>

            " 
            href="javascript:void(0);"
            rel="clickover" data-original-title="<%= first_name %> <%= last_name %>">
            <%= first_name %> <%= last_name %>
          </a>
        </td>
        <td><%= position %>&nbsp;</td>        
        <td><%= department %>&nbsp;</td>
        <td>
            <% if (contact) { %>
                <%= contact[0].contact %>
            <% } %>&nbsp;
        </td>
        <td><%= email %>&nbsp;</td>
        <td>
            <div class="btn-group">
                <a class="btn" rel="tooltip" title="Edit 201" 
                    href="<?php echo site_url();?>hr/employee/<%= hash %>#/edit">
                    <i class="icon-edit"></i>
                </a>            
                <a class="btn" rel="tooltip" title="View Profile" 
                    href="<?php echo site_url();?>profile/<%= hash %>">
                    <i class="icon-user"></i>
                </a>
                <a class="btn" rel="tooltip" title="View 201" 
                    href="<?php echo site_url();?>hr/employee/<%= hash %>">
                    <i class="icon-file"></i>
                </a>
                <a class="btn delete" rel="tooltip" title="Delete" 
                    href="#">
                    <i class="icon-trash"></i>
                </a>
            </div>
        </td>
    </script>
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
                $('#loadmore-employee').trigger('click');
            }
        });

        window.employeeListRouter = new EmployeeListRouter();

        Backbone.history.start();
    });
</script>
<?php echo $this->load->view('201/add');?>
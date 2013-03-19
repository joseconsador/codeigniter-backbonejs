    <style>  
    @media 
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {
    
      td:nth-of-type(1):before { content: "Name:"; }
      td:nth-of-type(2):before { content: "Position:"; }
      td:nth-of-type(3):before { content: "Department:"; }
      td:nth-of-type(4):before { content: "Status:"; }
      td:nth-of-type(5):before { content: "Phone:"; }
      td:nth-of-type(6):before { content: "Email:"; }
    }
    
    </style>

    <div class="container-fluid">
    
      <div class="row-fluid">
        
        <div class="span12">
    
          <div class="page-header">
            <h2><?php echo $this->lang->line('general_employee')?> <small>&raquo; Employee file</small></h2>
          </div>

          <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#tab-a" data-toggle="tab">Department A</a></li>
              <li><a href="#tab-b" data-toggle="tab">Department B</a></li>
              <li><a href="#tab-c" data-toggle="tab">Department C</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">More <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#tab-d" data-toggle="tab">Department D</a></li>
                  <li><a href="#tab-e" data-toggle="tab">Department E</a></li>
                </ul>
              </li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="tab-a">
                 <a class="btn btn-success" data-toggle="modal" href="#myModal" >Add New Employee</a>


                  <div class="btn-group pull-right hidden-phone">
                    <?php if (count($employees) > 0) echo $this->pagination->create_links()?>
                    <button class="btn disabled">Prev</button>
                    <button class="btn">Next</button>
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                    </button>
                
                    <ul class="dropdown-menu">
                      <li><a href="#">Show 50</a></li>
                      <li><a href="#">Show 150</a></li>
                      <li><a href="#">Show 250</a></li>
                    </ul>         
                  </div>

                  <table class="responsive-table">
                
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Phone</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php 
                      if (count($employees) > 0):
                        foreach ($employees as $employee): ?>
                      <tr>
                        <td><a href=""><?php echo $employee->first_name . ' ' . $employee->last_name;?></a></td>
                        <td><?php echo $employee->position;?></td>
                        <td><?php echo $employee->department;?></td>
                        <td><?php echo $employee->employment_status;?></td>
                        <td><?php echo $employee->contact;?></td>
                        <td><?php echo $employee->email;?></td>
                      </tr>
                      <?php
                        endforeach;
                      endif;?>
                    </tbody>
                  </table>
              </div>
              <div class="tab-pane fade in" id="tab-b">2</div>
              <div class="tab-pane fade in" id="tab-c">3</div>
              <div class="tab-pane fade in" id="tab-d">4</div>
              <div class="tab-pane fade in" id="tab-e">5</div>
            </div>

        </div>


      </div>
      
    </div>

    <!-- dialog box -->
    <?php $this->load->view('edit_201');?>
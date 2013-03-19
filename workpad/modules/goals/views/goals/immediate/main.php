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
      <div class="page-header"><h2>Goals</h2></div>
      <div class="row-fluid">

        <div class="span3">
          <ul class="nav nav-list">
            <li><a href="#" id="add-goal-btn"><i class="icon-plus"></i> Add new Goal</a></li>
            <li><a href="#" class="goal-filter" rel="null"><i class="icon-refresh"></i> Show All</a></li>
          </ul>
          <ul class="nav nav-list" id="my-goals-list">
            <li class="nav-header">My Goals</li>
          </ul>
          <ul class="nav nav-list" id="created-goals-list">
            <li class="nav-header">Created Goals</li>
          </ul>
        </div>
        
        <div class="span9">
          <?php $this->load->view('goals/immediate/goal_ui_main', $goals);?>          
        </div>
      </div>
    </div>
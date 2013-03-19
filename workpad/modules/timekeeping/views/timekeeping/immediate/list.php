<style>  
  @media 
  only screen and (max-width: 760px),
  (min-device-width: 768px) and (max-device-width: 1024px)  {
  
    td:nth-of-type(1):before { content: "Date:"; }
    td:nth-of-type(2):before { content: "Shift:"; }
    td:nth-of-type(3):before { content: "In:"; }
    td:nth-of-type(4):before { content: "Out:"; }
    td:nth-of-type(5):before { content: "Lates:"; }
    td:nth-of-type(6):before { content: "UT:"; }
    td:nth-of-type(7):before { content: "OT:"; }
  }

  #alert {display: none;}

</style>

<div class="container-fluid">
  
  <div class="row-fluid">
    
    <div class="span9">

      <div class="alert alert-error" id="alert">
        <button class="close" data-dismiss="alert" type="button">×</button>
        <strong></strong>
      </div>

      <div class="page-header">
          <h2>Time sheet</h2>
        </div>

        <form id="range-form" class="form-inline">
          <input type="text" value="" class="rangepicker" id="rangeA" placeholder="MM/DD/YYYY - MM/DD/YYYY" autocomplete="off" /> 
          <input type="text" id="employee-search" placeholder="Enter Employee's Name" autocomplete="off" />
          <input type="hidden" id="employee-id" />
          <button class="btn btn-primary">Generate Report</button>          
        </form>        
        <div class="hidden" id="notification-label"></div>
        <table class="responsive-table calendar-container">
            <thead>
              <tr>
                <th>Date</th>
                <th>Shift</th>
                <th>In</th>
                <th>Out</th>
                <th>Lates</th>
                <th>UT</th>
                <th>OT</th>
                <th>Forms</th>
              </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div><!--/span-->

    <div class="span3 visible-desktop">
      <ul class="nav nav-list">
        <li class="nav-header">Department A</li>
          <li><a href="#">Michelle Rodriguez</a></li>
          <li class="active"><a href="#">Juan Dela Cruz</a></li>
          <li><a href="#">Fort Bustolome</a></li>
          <li class="nav-header">Department B</li>
          <li><a href="#">Henry Smith</a></li>
          <li><a href="#">George Enriquez</a></li>
      </ul>
    </div>    
  </div><!--/row-->
</div>
<?php $this->load->view('template/timelog_calendar_row');?>
<script type="text/javascript">
  $(document).ready(function() {            
    timekeepingApp.collection = new EmployeeTimelogCollection();
    timekeepingApp.init();    

    timekeepingApp._logsView.employeeCollection = new EmployeeCollection(<?php echo json_encode($employees->data)?>);
    timekeepingApp.start();
    timekeepingApp._logsView.initTypeahead();
  });
</script>
<div class="container-fluid">
  <div class="page-header">
    <h2>Goal &amp; Objective</h2>
  </div>
    
  <div class="row-fluid">    
    <?php $this->load->view('goals/list');?>
  </div>
  <?php $this->load->view('goals/template/goal_item');?>
  <script type="text/javascript">
      $(document).ready(function() {          
          var goalCollection = new EmployeeGoalsCollection(<?php echo json_encode($goals->data)?>);
          var goalsMainView = new GoalsContainerView({
            collection: goalCollection
          });

          goalsMainView.render();
      });
  </script>
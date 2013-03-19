  <div id="goals-container">    
    <div class="clearfix"></div>

    <div id="goals-list"></div>
  </div>
  <?php $this->load->view('goals/template/goal_item');?>
  <!-- dialog box add goal -->
  <div class="modal hide" id="goal-edit-modal"></div>

  <!-- dialog box add objective -->
  <div class="modal hide" id="edit-objective-modal"></div>

  <?php $this->load->view('goals/template/employee_goals_modal');?>
  <?php $this->load->view('goals/template/goal_edit_template');?>
  <?php $this->load->view('goals/template/goal_objective_edit_template');?>

  <div id="goal-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Goal</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this goal.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>


<div id="objective-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Objective</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this objective.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>
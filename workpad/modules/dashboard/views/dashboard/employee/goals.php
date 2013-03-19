<?php foreach ($goals->data as $goal):
  $class = 'goal-in-progress';
  $total_complete = 0;
  $curr_date = strtotime(date('Y-m-d'));

  if (strtotime($goal->start_date) > $curr_date) {
    $goal_status = 'Pending';
    $class = 'goal-idle';
  } elseif (strtotime($goal->start_date) < $curr_date) {
    $goal_status = 'In Progress';
  } else {
    $goal_status = $goal->status;
  }
?>

<div class="well goals-box <?php echo $class;?>">        

  <div class="pull-right">
    <h3><span id="goal-<?php echo $goal->goal_id;?>-completion"></span> <?php echo $goal_status;?></h3>
  </div>
  <h3><?php echo _p($goal, 'title');?> <span class="label <?php if ($goal->status_id == Goal::SUCCESS_STATUS_ID) echo 'label-success';?>"><?php echo _p($goal, 'points');?> pts</span></h3>
  <p>
  on <i><?php echo _d($goal->target, 'M j, Y');?></i>
  </p>
  <?php if (isset($goal->items) && count($goal->items) > 0):?>
  <table class="table table-condensed">
      
    <thead>
      <tr>
        <th>Summary</th>        
        <th>Status</th>
        <th>Created on</th>
      </tr>
    </thead>

    <tbody>
      <?php 
        foreach ($goal->items as $goal_item): 
          $total_complete += ($goal_item->status_id == Goal::SUCCESS_STATUS_ID) ? 1 : 0; 
      ?>
      <tr>                       
        <td><?php echo _p($goal_item, 'description');?></td>        
        <td><?php echo _p($goal_item, 'status');?></td>
        <td><?php echo _d($goal_item->created, 'D, M j');?></td>
      </tr>        
      <?php endforeach;?>
      <?php $percentage = floor(($total_complete / count($goal->items)) * 100);?>
      <script type="text/javascript">
        $(document).ready(function() {
          $('#goal-<?php echo $goal->goal_id;?>-completion').text('<?php echo $percentage;?>%');
        });
      </script>      
    </tbody>
  </table>
  <?php endif;?>
</div>
<?php endforeach;?>

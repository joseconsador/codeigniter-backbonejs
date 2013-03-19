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
  <h3><?php echo _p($goal, 'title');?> <span class="label <?php if ($goal->status_id == 75) echo 'label-success';?>"><?php echo _p($goal, 'points');?> pts</span></h3>
  <p>
  on <i><?php echo _d($goal->target, 'M j, Y');?></i>
  </p>
  <p><?php echo _p($goal, 'description');?></p>
  <?php if (!is_null($goal->items) && count($goal->items) > 0): ?>
    <ol>
    <?php 
      foreach ($goal->items as $index => $goal_item): 
        $total_complete += ($goal_item->status_id == 75) ? 1 : 0; 
    ?>
      <li<?php if ($index == count($goal->items) - 1) echo ' style="border:0"';?>><?php echo _p($goal_item, 'description');?>&nbsp;
        <span class="label <?php if ($goal_item->status_id == 75) echo 'label-success';?>"><?php echo $goal_item->points;?> pts</span>
      </li>
    <?php endforeach;?>
    </ol>
  <?php $percentage = floor(($total_complete / count($goal->items)) * 100);?>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#goal-<?php echo $goal->goal_id;?>-completion').text('<?php echo $percentage;?>%');
    });
  </script>
  <?php endif;?>
</div>
<?php endforeach;?>
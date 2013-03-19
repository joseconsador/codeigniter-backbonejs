<?php $this->load->view('goals/list');?>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($goals->_count > 0) {?>
            var goalCollection = new EmployeeGoalsCollection(<?php echo json_encode($goals->data)?>);
        <?php } else {?>
            var goalCollection = new EmployeeGoalsCollection();
        <?php } ?>

        goalCollection.employee_id = <?php echo $employee_id;?>;

        var goalsMainView = new GoalsContainerView({
          collection: goalCollection,
          subordinates: <?php echo json_encode($subordinates->data);?>
        });

        goalsMainView.render();
    });
</script>


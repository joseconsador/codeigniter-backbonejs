<div class="container-fluid">
  <div class="page-header">
    <h2>Rewards Shop</h2>
  </div>

  <div class="row-fluid" id="rewards-container">
    <div class="span12">
      <p><button class="btn btn-primary" id="add-reward">New Reward</button></p>
    </div>
    <?php $this->load->view('rewards/template/list_item_edit');?>
  </div>

  <div class="modal hide" id="reward-edit-modal"></div>
  <?php $this->load->view('rewards/template/reward_edit_template');?>  
  <script type="text/javascript">
    $(document).ready(function() {
      <?php if ($rewards->_count > 0):?>
      var rewardsCollection = new RewardsCollection(<?php echo json_encode($rewards->data)?>);
      <?php ; else : ?>
      var rewardsCollection = new RewardsCollection();
      <?php endif;?>

      var rewardShopView = new RewardShopView({collection: rewardsCollection});

      rewardShopView.render();
    });
  </script>